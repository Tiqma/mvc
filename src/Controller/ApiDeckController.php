<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\Player;
use App\Game\Bank;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;

class ApiDeckController extends AbstractController
{
    private DeckOfCards $deckOfCardsService;

    public function __construct(DeckOfCards $deckOfCardsService)
    {
        $this->deckOfCardsService = $deckOfCardsService;
    }
    #[Route("/api/deck", name: "api_deck_get", methods: ['GET'])]
    public function init(SessionInterface $session): JsonResponse
    {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);

        $response = [
            'message' => 'Deck initialized successfully.',
            'cards' => $deck->getDeck(),
        ];

        return new JsonResponse($response);
    }

    #[Route("/api/deck/shuffle", name: "api_shuffle_post", methods: ['POST'])]
    public function initCallback(SessionInterface $session): JsonResponse
    {
        $deck = $session->get("deck", new DeckOfCards());

        if ($deck === null) {
            throw new RuntimeException("Deck not initialized.");
        }

        if (!$deck instanceof DeckOfCards) {
            throw new RuntimeException("Invalid deck in session.");
        }

        $deck->shuffleDeck();

        $session->set('deck', $deck->getDeck());
        $response = [
            'message' => 'Deck shuffled successfully.',
            'cards' => $deck->getDeck(),
        ];

        return new JsonResponse($response);
    }

    #[Route("/api/deck/draw", name: "api_deck_draw_one", methods: ['POST'])]
    public function drawOneCard(SessionInterface $session): JsonResponse
    {
        /** @var string[] $deckData */
        $deckData = $session->get('deck');
        $deck = $this->deckOfCardsService->createFromSession($deckData);
        $drawnCard = $deck->drawCard();
        $remainingCards = $deck->countCards();

        $session->set('deck', $deck->getDeck());

        $data = [
            'drawn_card' => $drawnCard,
            'remaining_cards' => $remainingCards,
        ];

        return new JsonResponse($data);
    }

    #[Route("/api/deck/draw/{numCards<\d+>}", name: "api_deck_draw_more", methods: ['POST'])]
    public function drawMoreCards(SessionInterface $session, int $numCards): JsonResponse
    {
        /** @var string[] $deckData */
        $deckData = $session->get('deck');
        $deckOfCards = $this->deckOfCardsService->createFromSession($deckData);
        $drawnCards = $deckOfCards->drawCards($numCards);
        $drawnCards = $drawnCards->getHand();

        $remainingCardsCount = $deckOfCards->countCards();

        $session->set('deck', $deckOfCards->getDeck());

        $data = [
            'drawn_cards' => $drawnCards,
            'remaining_cards' => $remainingCardsCount,
        ];

        return new JsonResponse($data);
    }
}
