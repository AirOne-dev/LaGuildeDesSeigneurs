<?php

namespace App\Service;

interface CharacterServiceInterface
{
    public function create();

    public function getAll();

    public function getImages(int $number, ?string $kind = null);

    public function getImagesKind(string $kind, int $number);

}