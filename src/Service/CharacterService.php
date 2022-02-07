<?php

namespace App\Service;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
}