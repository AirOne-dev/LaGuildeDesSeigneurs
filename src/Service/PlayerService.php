<?php

namespace App\Service;

use App\Entity\Player;
use App\Event\PlayerEvent;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PlayerService implements PlayerServiceInterface
{
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher, private readonly EntityManagerInterface $em, private readonly PlayerRepository $playerRepository, private readonly FormFactoryInterface $formFactory, private readonly ValidatorInterface $validator)
    {
        $this->dispatcher = $dispatcher;
    }

    public function create(string $data): Player
    {
        $player = new Player();
        $player
            ->setCreationDate(new \DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
            ->setModification(new \DateTime());

        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function isEntityFilled(Player $player)
    {
        $errors = $this->validator->validate($player);
        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException((string) $errors . ' Missing data for Entity -> ' . $player::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submit(Player $player, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $player, ['csrf_protection' => false]);
        $form->submit($dataArray, false);//With false, only submitted fields are validated

        //Gets errors
        $errors = $form->getErrors();
        foreach ($errors as $error) {
            throw new LogicException('Error ' . $error->getCause()::class . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters(), JSON_THROW_ON_ERROR));
        }
    }

    public function getAll(): array
    {
        return $this->playerRepository->findAll();
    }

    public function modify(Player $player, string $data): Player
    {
        $this->submit($player, PlayerType::class, $data);
        $event = new PlayerEvent($player);
        $this->dispatcher->dispatch($event, PlayerEvent::PLAYER_UPDATED);
        $this->isEntityFilled($player);
        $player->setModification(new \DateTime());

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    public function delete(Player $player): bool
    {
        $this->em->remove($player);
        $this->em->flush();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function serializeJson($data)
    {
        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn($data) => $data->getIdentifier(),
            ];
        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizers], [$encoders]);
        return $serializer->serialize($data, 'json');
    }
}
