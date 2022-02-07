<?php

namespace App\Controller;

use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService) {
        $this->characterService = $characterService;
    }

    #[Route('/', name: 'index', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    #[Route('/character/display/{identifier}', name: 'character_display', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ['GET', 'HEAD'])]
    public function display(Character $character): Response
    {
        $this->denyAccessUnlessGranted('CharacterDisplay', $character);
        return new JsonResponse($character->toArray());
    }

    #[Route('/character/create', name: 'character_create', methods: ['POST', 'HEAD'])]
    public function create(): Response
    {
        $character = $this->characterService->create();
        $this->denyAccessUnlessGranted('CharacterCreate', $character);
        return new JsonResponse($character->toArray());
    }
}
