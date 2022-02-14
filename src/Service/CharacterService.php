<?php

namespace App\Service;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

class CharacterService implements CharacterServiceInterface
{
    private $em;
    private $characterRepository;

    public function __construct(EntityManagerInterface $em, CharacterRepository $cr)
    {
        $this->em = $em;
        $this->characterRepository = $cr;
    }

    public function create() {
        $character = new Character();
        $character
            ->setKind('Seigneur')
            ->setName('Curambar')
            ->setSurname('Maître du destin')
            ->setCaste('Erudit')
            ->setKnowledge('Lettres')
            ->setIntelligence(140)
            ->setLife(10)
            ->setImage('/images/Curambar.jpeg')
            ->setCreation(new \DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
            ->setModification(new \DateTime());

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }

    public function getAll()
    {
       $charactersFinal = [];
       $characters = $this->characterRepository->findAll();
       foreach ($characters as $character) {
           $charactersFinal[] = $character->toArray();
       }

       return $charactersFinal;
    }

    public function modify(Character $character) {
        $character
            ->setKind('Seigneur')
            ->setName('Curambar')
            ->setSurname('Maître du destin')
            ->setCaste('Erudit')
            ->setKnowledge('Lettres')
            ->setIntelligence(140)
            ->setLife(10)
            ->setImage('/images/Curambar.jpeg')
            ->setModification(new \DateTime());

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }

    public function delete(Character $character) {
        $this->em->remove($character);
        $this->em->flush();
        return true;
    }

    public function getImages(int $number, ?string $kind = null)
    {
        $folder = __DIR__ . '/../../public/images/';
        $finder = new Finder(); $finder
        ->files()
        ->in($folder)
        ->notPath('/cartes/')
        ->sortByName();

        if (null !== $kind) {
            $finder->path('/' . $kind . '/');
        }

        $images = array();
        foreach ($finder as $file) {
            $images[] = '/images/' . $file->getPathname();
        }
        shuffle($images);
        return array_slice($images, 0, $number, true);
    }

    public function getImagesKind(string $kind, int $number)
    {
        return $this->getImages($number, $kind);
    }
}