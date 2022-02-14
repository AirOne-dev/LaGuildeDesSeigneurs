<?php

namespace App\Service;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;

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
            ->setIdentifier(hash('sha1', uniqid()));

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

    public function modify() {
        $character = new Character();
        $character
            ->setKind('Seigneur')
            ->setName('Curambar')
            ->setSurname('Maître du destin')
            ->setCaste('Erudit')
            ->setKnowledge('Lettres')
            ->setIntelligence(140)
            ->setLife(10)
            ->setImage('/images/Curambar.jpeg');

        $this->em->persist($character);
        $this->em->flush();

        return $character;
    }
}