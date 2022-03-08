<?php

namespace App\Listener;

use App\Event\PlayerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlayerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            PlayerEvent::PLAYER_UPDATED => 'playerUpdated'
        );
    }

    public function playerUpdated($event)
    {
        $player = $event->getPlayer();
        if($player->getMirian() >= 10) {
            $player->setMirian($player->getMirian() - 10);
        } else {
            $player->setMirian(0);
        }
    }
}