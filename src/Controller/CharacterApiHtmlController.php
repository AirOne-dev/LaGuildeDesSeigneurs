<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterApiHtmlType;
use App\Form\CharacterHtmlType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\CharacterServiceInterface;

#[Route('/character/api-html')]
class CharacterApiHtmlController extends AbstractController
{
    private $characterService;
    private $client;

    public function __construct(CharacterServiceInterface $characterService, HttpClientInterface $client)
    {
        $this->characterService = $characterService;
        $this->client = $client;
    }

    #[Route('/', name: 'character_api_html_index', methods: ['GET'])]
    public function index(): Response
    {
        $response = $this->client->request('GET','http://caddy/character');
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    #[Route('/new', name: 'character_api_html_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = new Character();
        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->createFromHtml($character);

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $character->getIdentifier(),
            ));
        }

        return $this->renderForm('character_api_html/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{identifier}', name: 'character_api_html_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('character_html/show.html.twig', [
            'character' => $character,
        ]);
    }

    #[Route('/{identifier}/edit', name: 'character_api_html_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->modifyFromHtml($character);

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $character->getIdentifier(),
            ));
        }

        return $this->renderForm('character_api_html/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{identifier}/delete', name: 'character_api_html_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Character $character): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getIdentifier(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('character_api_html_index', [], Response::HTTP_SEE_OTHER);
    }
}