<?php

namespace App\Listener;

use App\Event\CharacterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CharacterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            CharacterEvent::CHARACTER_CREATED => 'characterCreated',
            CharacterEvent::CHARACTER_UPDATED => 'characterUpdated'
            );
    }

    public function characterCreated($event)
    {
        $character = $event->getCharacter();
        $character->setIntelligence(250);

        $currentDate = date('Y-m-d');
        $currentDate = date('Y-m-d', strtotime($currentDate));

        $startDate = date('Y-m-d', strtotime("03/08/2022"));
        $endDate = date('Y-m-d', strtotime("03/30/2022"));

        if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
            $character = $event->getCharacter();
            $character->setLife(20);
        }
    }

    public function characterUpdated($event)
    {
        $character = $event->getCharacter();
        if($character->getMirian() >= 10) {
            $character->setMirian($character->getMirian() - 10);
        } else {
            $character->setMirian(0);
        }
    }
}