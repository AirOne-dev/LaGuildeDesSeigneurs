<?php

namespace App\Service;

use App\Entity\Player;

interface PlayerServiceInterface
{
    public function create(string $data);
    public function getAll();
    public function delete(Player $player);
    public function modify(Player $player, string $data);

    /**
     * Serialize the object(s)
     */
    public function serializeJson($data);

    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Player $player);

    /**
     * Submits the data to hydrate the object
     */
    public function submit(Player $player, $formName, $data);
}
