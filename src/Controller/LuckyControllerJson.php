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

class LuckyControllerJson extends AbstractController
{
    private DeckOfCards $deckOfCardsService;

    public function __construct(DeckOfCards $deckOfCardsService)
    {
        $this->deckOfCardsService = $deckOfCardsService;
    }
    #[Route("/api", name: "api")]
    public function apiLandingPage(): Response
    {
        $landing = "/api";
        $quote = "/api/quote";
        $deck = "/api/deck";
        $deckShuffle = "/api/deck/shuffle";
        $deckDraw = "/api/deck/draw";
        $deckDrawMore = "/api/deck/draw/{number}";
        $gameStatus = "/api/game";

        $routes = [
            'landing' => $landing,
            'quote' => $quote,
            'deck' => $deck,
            'shuffle' => $deckShuffle,
            'draw' => $deckDraw,
            'drawMore' => $deckDrawMore,
            'game' => $gameStatus
        ];

        return $this->render('api/api.html.twig', [
            'routes' => $routes,
        ]);
    }
}
