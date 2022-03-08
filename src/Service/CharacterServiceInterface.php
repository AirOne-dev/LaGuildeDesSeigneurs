<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    public function create(string $data);

    public function modify(Character $character, string $data);

    public function getAll();

    public function getImages(int $number, ?string $kind = null);

    public function getImagesKind(string $kind, int $number);

    /*** Checks if the entity has been well filled*/
    public function isEntityFilled(Character $character);

    /*** Submits the data to hydrate the object*/
    public function submit(Character $character, $formName, $data);

    public function serializeJson($data);

    /**
     * Creates the character from html form
     */
    public function createFromHtml(Character $character);

}
