<?php

namespace App\Security\Voter;

use App\Entity\Player;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PlayerVoter extends Voter
{
    public final const PLAYER_DISPLAY = 'playerDisplay';
    public final const PLAYER_CREATE = 'playerCreate';
    public final const PLAYER_UPDATE = 'playerUpdate';
    public final const PLAYER_DELETE = 'playerDelete';

    public final const ATTRIBUTES = [
        self::PLAYER_DISPLAY,
        self::PLAYER_CREATE,
        self::PLAYER_UPDATE,
        self::PLAYER_DELETE
    ];

    protected function supports(string $attribute, $subject): bool
    {
        if ($subject !== null) {
            return $subject instanceof Player && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return match ($attribute) {
            self::PLAYER_DISPLAY => $this->canDisplay(),
            self::PLAYER_CREATE => $this->canCreate(),
            self::PLAYER_UPDATE => $this->canUpdate(),
            self::PLAYER_DELETE => $this->canDelete(),
            default => throw new LogicException('Invalid attribute: ' . $attribute),
        };
    }

    /**
     * Checks if is allowed to display
     */
    private function canDisplay(): bool
    {
        return true;
    }

    /**
     * Checks if is allowed to create
     */
    private function canCreate(): bool
    {
        return true;
    }

    /**
     * Checks if is allowed to UPDATE
     */
    private function canUpdate(): bool
    {
        return true;
    }

    /**
     * Checks if is allowed to delete
     */
    private function canDelete(): bool
    {
        return true;
    }
}
