<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('/character', name: 'character')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    #[Route('/character/display', name: 'character_display')]
    public function display(): Response
    {
        $character = new Character();
        dump($character);
        echo '<image width="400" src="'.$character->getImage().'">';
        return $this->json([
            $character->toArray()
        ]);
    }
}
