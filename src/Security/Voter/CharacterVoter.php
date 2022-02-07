<?php

namespace App\Security\Voter;

use App\Entity\Character;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CharacterVoter extends Voter
{

    public const CHARACTER_DISPLAY = 'CharacterDisplay';
    public const CHARACTER_CREATE = 'CharacterCreate';

    public const ATTRIBUTES = [
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE
    ];


    protected function supports(string $attribute, $subject): bool
    {
        if($subject !== null) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CHARACTER_DISPLAY:
                return $this->canDisplay();
                break;
            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;
        }

        throw new LogicException('Invalid attribute: ' . $attribute);
    }

    /**
     * Checks if is allowed to display
     */
    private function canDisplay()
    {
        return true;
    }

    /**
     * Checks if is allowed to create
     */
    private function canCreate()
    {
        return true;
    }
}
