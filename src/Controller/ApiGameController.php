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

class ApiGameController extends AbstractController
{
    private DeckOfCards $deckOfCardsService;

    public function __construct(DeckOfCards $deckOfCardsService)
    {
        $this->deckOfCardsService = $deckOfCardsService;
    }

    #[Route("/api/game", name: "api_game_status", methods: ['GET'])]
    public function gameStatus(SessionInterface $session): JsonResponse
    {
        /** @var Player $player */
        $player = $session->get('player');
        /** @var Bank $banker */
        $banker = $session->get('banker');
        /** @var string[] $deckData */
        $deckData = $session->get('deck');
        $deck = $this->deckOfCardsService->createFromSession($deckData);

        $data = [
            'player' => [
                'hand' => $player->getHand(),
                'total_points' => $player->getTotalPoints(),
            ],
            'banker' => [
                'hand' => $banker->getHand(),
                'total_points' => $banker->getTotalPoints(),
            ],
            'deck' => [
                'remaining_cards' => $deck->countCards(),
            ],
        ];

        return new JsonResponse($data);
    }

    #[Route('/api/library/books', name: 'api_books', methods: ['GET'])]
    public function getBooks(BookRepository $bookRepository): JsonResponse
    {
        $books = $bookRepository->findAll();
        $data = [];

        foreach ($books as $book) {
            $data[] = [
                'title' => $book->getTitle(),
                'isbn' => $book->getIsbn(),
                'author' => $book->getAuthor(),
                'image' => $book->getImage(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/library/book/{isbn}', name: 'api_book', methods: ['GET'])]
    public function getBookByIsbn(string $isbn, BookRepository $bookRepository): JsonResponse
    {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            return new JsonResponse(['error' => 'Book not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [
            'title' => $book->getTitle(),
            'isbn' => $book->getIsbn(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
        ];

        return new JsonResponse($data);
    }
}
