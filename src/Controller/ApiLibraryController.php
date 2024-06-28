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

class ApiLibraryController extends AbstractController
{
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
