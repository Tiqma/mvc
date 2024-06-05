<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Find all producs having a value above the specified one.
     *
     * @param float|int $value
     * @return Product[] Returns an array of Product objects
     */
    public function findByMinimumValue(float|int $value): array
    {
        /** @var Product[] $result */
        $result = $this->createQueryBuilder('p')
            ->andWhere('p.value >= :value')
            ->setParameter('value', $value)
            ->orderBy('p.value', 'ASC')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Find all producs having a value above the specified one with SQL.
     *
     * @param float|int $value
     * @return array<int, array<string, mixed>> Returns an array of arrays (i.e., a raw data set)
     */
    public function getAllBooks($value): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM product
        ';

        $resultSet = $conn->executeQuery($sql, ['value' => $value]);

        return $resultSet->fetchAllAssociative();
    }

}
