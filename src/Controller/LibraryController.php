<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route('/library/create', name: 'book_create')]
    public function createBookForm(): Response
    {
        return $this->render('library/create.html.twig');
    }

    #[Route('/library/store', name: 'book_store', methods: ['POST'])]
    public function storeBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $title = (string) $request->request->get('title', '');
        $isbn = (string) $request->request->get('isbn', '');
        $author = (string) $request->request->get('author', '');
        $image = (string) $request->request->get('image', '');

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImage($image);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_library');
    }

    #[Route('/library/read_many', name: 'book_list', methods: ['GET'])]
    public function listBooks(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->getAllBooks();

        return $this->render('library/list.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/library/{isbn}', name: 'book_show', methods: ['GET'])]
    public function showBook(
        string $isbn,
        BookRepository $bookRepository
    ): Response {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->render('library/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/library/book/{isbn}/edit', name: 'book_edit', methods: ['GET'])]
    public function editBookForm(
        string $isbn,
        BookRepository $bookRepository
    ): Response {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->render('library/edit.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/library/book/{isbn}/update', name: 'book_update', methods: ['POST'])]
    public function updateBook(
        string $isbn,
        Request $request,
        ManagerRegistry $doctrine,
        BookRepository $bookRepository
    ): Response {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $title = (string) $request->request->get('title', '');
        $author = (string) $request->request->get('author', '');
        $image = (string) $request->request->get('image', '');

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setImage($image);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_show', ['isbn' => $book->getIsbn()]);
    }

    #[Route('/library/book/{isbn}/delete', name: 'book_delete', methods: ['POST'])]
    public function deleteBook(
        string $isbn,
        ManagerRegistry $doctrine,
        BookRepository $bookRepository
    ): Response {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_list');
    }
}
