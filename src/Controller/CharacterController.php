<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    #[Route('/character/display', name: 'character_display', methods: ['GET', 'HEAD'])]
    public function display(): Response
    {
        $character = new Character();
        return new JsonResponse($character->toArray());
    }
}
