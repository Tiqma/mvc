<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson extends AbstractController
{
    #[Route("/api", name: "api")]
    public function apiLandingPage(): Response
    {
        $landing = "/api";
        $quote = "/api/quote";
        $deck = "/api/deck";
        $deckShuffle = "/api/deck/shuffle";
        $deckDraw = "/api/deck/draw";
        $deckDrawMore = "/api/deck/draw/{number}";

        $routes = [
            'landing' => $landing,
            'quote' => $quote,
            'deck' => $deck,
            'shuffle' => $deckShuffle,
            'draw' => $deckDraw,
            'drawMore' => $deckDrawMore
        ];

        return $this->render('api/api.html.twig', [
            'routes' => $routes,
        ]);
    }

    #[Route("/api/quote", name: "api_quote")]
    public function getQuote(): JsonResponse
    {
        $quotes = [
            "Förändring är lagen för livet. Och de som ser bara på det förflutna 
            eller nuet är säkert att missa framtiden.",
            "Den som kontrollerar kryddan, kontrollerar universum.",
            "Styrkan hos en person ligger inte i deras fysiska förmåga, 
            utan i deras förmåga att kontrollera sina tankar.",
        ];

        $randomQuote = $quotes[array_rand($quotes)];


        $data = [
            'quote' => $randomQuote,
            'date' => date('Y-m-d'),
            'timestamp' => time(),
        ];

        return new JsonResponse($data);
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
            throw new \RuntimeException("Deck not initialized.");
        }

        if (!$deck instanceof DeckOfCards) {
            throw new \RuntimeException("Invalid deck in session.");
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
        /** @var string[] $deck */
        $deck = $session->get("deck");
        $deck = DeckOfCards::createFromSession($deck);
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
        /** @var string[] $deckOfCards */
        $deckOfCards = $session->get('deck');
        $deckOfCards = DeckOfCards::createFromSession($deckOfCards);
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
