<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Find all books with SQL.
     *
     * @return array<int, array<string, mixed>> Returns an array of arrays (i.e., a raw data set)
     */
    public function getAllBooks(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM book';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }
}
