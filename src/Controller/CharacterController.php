<?php

namespace App\Controller;

use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CharacterController extends AbstractController
{
    public function __construct(private readonly CharacterServiceInterface $characterService)
    {
    }

    //DISPLAY
    /**
    * Displays the Character
     *
     * ...
     *
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Character",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/display/{identifier}', name: 'character_display', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ['GET', 'HEAD'])]
    #[Entity('character', expr:'repository.findOneByIdentifier(identifier)')]
    public function display(EventDispatcherInterface $dispatcher, Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //CREATE
    /**
     * Creates the Character
     *
     * ...
     *
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\RequestBody(
     *     request="Character",
     *     description="Data for the Character",
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Character")
     *     )
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/create', name: 'character_create', methods: ['POST', 'HEAD'])]
    public function create(Request $request): Response
    {
        $character = $this->characterService->create($request->getContent());
        $this->denyAccessUnlessGranted('characterCreate', $character);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //INDEX
    /**
     * Redirects to index Route
     *
     * ...
     *
     * @OA\Response(
     *     response=302,
     *     description="Redirect",
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character', name: 'character_redirect_index', methods: ['GET', 'HEAD'])]
    public function redirectToIndex(): Response
    {
        return $this->redirectToRoute('character_index');
    }

    //INDEX
    /**
     * Displays available Characters
     *
     * ...
     *
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(ref=@Model(type=Character::class))
     *     )
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/index', name: 'character_index', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAll();
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    //MODIFY
    /**
     * Modifies the Character
     *
     * ...
     *
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Character",
     *     required=true
     * )
     * @OA\RequestBody(
     *     request="Character",
     *     description="Data for the Character",
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Character")
     *     )
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/modify/{identifier}', name: 'character_modify', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ['PUT', 'HEAD'])]
    public function modify(Request $request, Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->modify($character, $request->getContent());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //DELETE
    /**
     * Deletes the Character
     *
     * ...
     *
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\Schema(
     *         @OA\Property(property="delete", type="boolean"),
     *     )
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Character",
     *     required=true
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/delete/{identifier}', name: 'character_delete', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ['DELETE', 'HEAD'])]
    public function delete(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);
        $response = $this->characterService->delete($character);
        return new JsonResponse(array('delete' => $response));
    }

    //DISPLAY
    /**
     * Displays the image of a Character
     *
     * ...
     *
     * @OA\Parameter(
     *     name="number",
     *     in="path",
     *     description="identifier for the Image",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success"
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/images/{number}', name: 'character_images', requirements: ['number' => '^([0-9]{1,2})$'], methods: ['GET', 'HEAD'])]
    public function images(int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImages($number));
    }

    //DISPLAY
    /**
     * Displays the image of a Character Kind
     *
     * ...
     *
     * @OA\Parameter(
     *     name="kind",
     *     in="path",
     *     description="The Kind",
     *     required=true,
     * )
     * @OA\Parameter(
     *     name="number",
     *     in="path",
     *     description="The Number",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success"
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/images/{kind}/{number}', name: 'character_images_kind', requirements: ['number' => '^([0-9]{1,2})$'], methods: ['GET', 'HEAD'])]
    public function imagesKind(string $kind, int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImagesKind($kind, $number));
    }
}
