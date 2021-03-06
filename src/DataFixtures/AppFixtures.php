<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Player;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $character = new Character();
            $character->setKind(random_int(0, 1) ? 'Dame' : 'Seigneur')
                ->setName('Eldalótë' . $i)
                ->setSurname('Fleur elfique')
                ->setCaste('Elfe')
                ->setKnowledge('Arts')
                ->setIntelligence(random_int(100, 200))
                ->setLife(random_int(10, 20))
                ->setImage('/images/eldalote.jpg')
                ->setIdentifier(hash('sha1', uniqid()))
                ->setCreation(new DateTime());
            $manager->persist($character);
        }
        $manager->flush();

        for ($i = 0; $i < 10; $i++) {
            $player = new Player();
            $player
                ->setFirstname('Maë' . $i)
                ->setLastname('MARTIN' . $i)
                ->setEmail('mae311010@gmail.com')
                ->setMirian(random_int(0, 500));
            $manager->persist($player);
        }
        $manager->flush();
    }
}
