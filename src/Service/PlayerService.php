<?php

namespace App\Service;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService implements PlayerServiceInterface
{
    private EntityManagerInterface $em;
    private PlayerRepository $playerRepository;

    public function __construct(EntityManagerInterface $em, PlayerRepository $cr)
    {
        $this->em = $em;
        $this->playerRepository = $cr;
    }

    public function create(): Player
    {
        $player = new Player();
        $player
            ->setFirstname('Erwan')
            ->setLastname('MARTIN')
            ->setEmail('erwan1207@gmail.com')
            ->setMirian(0)
            ->setCreationDate(new \DateTime());

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    public function getAll(): array
    {
        $playersFinal = [];
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $playersFinal[] = $player->toArray();
        }

        return $playersFinal;
    }

    public function update(Player $player): Player
    {
        $player
            ->setFirstname('Maë')
            ->setLastname('MARTIN')
            ->setEmail('mae311010@gmail.com')
            ->setMirian(0)
            ->setCharacterId(1);

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
}