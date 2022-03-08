<?php

namespace App\Event;

use App\Entity\Character;
use Symfony\Contracts\EventDispatcher\Event;

class CharacterEvent extends Event
{
    public const CHARACTER_CREATED = 'app.character.created';
    public const CHARACTER_DISPLAYED = 'app.character.displayed';
    protected $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function getCharacter()
    {
        return $this->character;
    }
}