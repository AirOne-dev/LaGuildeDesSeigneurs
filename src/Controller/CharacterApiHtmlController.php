<?php

namespace App\Controller;

use App\Form\CharacterApiHtmlType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/character/api-html')]
class CharacterApiHtmlController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/', name: 'character_api_html_index', methods: ['GET'])]
    public function index(): Response
    {
        // pour docker, on remplace 'localhost' par 'caddy' pour les requêtes internes au serveur
        $response = $this->client->request('GET','http://caddy/character/index');
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    #[Route('/new', name: 'character_api_html_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {

        $character = array();
        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // pour docker, on remplace 'localhost' par 'caddy' pour les requêtes internes au serveur
            $response = $this->client->request('POST','http://caddy/character/create',['json' => $request->request->all()['character_api_html'],]);

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $response->toArray()['identifier'],
            ));
        }

        return $this->renderForm('character_api_html/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{identifier}', name: 'character_api_html_show', methods: ['GET'])]
    public function show(string $identifier): Response
    {
        // pour docker, on remplace 'localhost' par 'caddy' pour les requêtes internes au serveur
        $response = $this->client->request('GET','http://caddy/character/display/' . $identifier);
        return $this->render('character_api_html/show.html.twig', ['character' => $response->toArray(),]);
    }

    #[Route('/{identifier}/edit', name: 'character_api_html_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, string $identifier): Response
    {
        // pour docker, on remplace 'localhost' par 'caddy' pour les requêtes internes au serveur
        $response = $this->client->request('GET','http://caddy/character/display/' . $identifier);
        $character = $response->toArray();

        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // pour docker, on remplace 'localhost' par 'caddy' pour les requêtes internes au serveur
            $this->client->request('PUT','http://caddy/character/modify/' . $identifier,['body' => json_encode($request->request->all()['character_api_html'])]);

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $identifier,
            ));
        }

        return $this->renderForm('character_api_html/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{identifier}/delete', name: 'character_api_html_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, string $identifier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$identifier, $request->request->get('_token'))) {
            // pour docker, on remplace 'localhost' par 'caddy' pour les requêtes internes au serveur
            $this->client->request('DELETE','http://caddy/character/delete/' . $identifier);
        }

        return $this->redirectToRoute('character_api_html_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/intelligence/{level}', name: 'character_api_html_index_intel_lvl', methods: ['GET'])]
    public function intelligence(Int $level): Response
    {
        // pour docker, on remplace 'localhost' par 'caddy' pour les requêtes internes au serveur
        $response = $this->client->request('GET','http://caddy/character/intelligence/'.$level);
        return $this->render('character_api_html/index.html.twig', ['characters' => $response->toArray(),]);
    }
}