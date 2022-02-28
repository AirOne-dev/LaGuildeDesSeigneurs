<?php

namespace App\Controller;

use App\Entity\Player;
use App\Service\PlayerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class PlayerController extends AbstractController
{
    public function __construct(private readonly PlayerServiceInterface $playerService)
    {
    }

    #[Route('/player/display/{identifier}', name: 'player_display', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ['GET', 'HEAD'])]
    #[Entity('player', expr:'repository.findOneByIdentifier(identifier)')]
    public function display(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerDisplay', $player);
        return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
    }

    #[Route('/player/create', name: 'player_create', methods: ['POST', 'HEAD'])]
    public function create(Request $request): Response
    {
        $player = $this->playerService->create($request->getContent());
        $this->denyAccessUnlessGranted('playerCreate', $player);
        return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
    }

    #[Route('/player', name: 'player_redirect_index', methods: ['GET', 'HEAD'])]
    public function redirectToIndex(): Response
    {
        return $this->redirectToRoute('player_index');
    }

    #[Route('/player/index', name: 'player_index', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('playerDisplay', null);
        $players = $this->playerService->getAll();
        return JsonResponse::fromJsonString($this->playerService->serializeJson($players));
    }

    #[Route('/player/modify/{identifier}', name: 'player_update', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ['PUT', 'HEAD'])]
    public function modify(Request $request, Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerUpdate', $player);
        $player = $this->playerService->modify($player, $request->getContent());
        return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
    }

    #[Route('/player/delete/{identifier}', name: 'player_delete', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ['DELETE', 'HEAD'])]
    public function delete(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerDelete', $player);
        $response = $this->playerService->delete($player);
        return new JsonResponse(array('delete' => $response));
    }
}
