<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Clients>
 */
class ClientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clients::class);
    }
    public function findByFilters(Clients $filters): ?array
    {
//        $queryBuilder = $this->createQueryBuilder('cli');
//
//        foreach ($filters as $field => $value) {
//            if ($value !== null || $value !== '') {
//                $queryBuilder->andWhere("cli.$field = :$field")
//                    ->setParameter($field, $value);
//            }
//        }
        $queryBuilder = $this->createQueryBuilder('cli');
        $entityManager = $this->getEntityManager();
        $metadata = $entityManager->getClassMetadata(Clients::class);
        $properties = $metadata->getFieldNames();
        foreach ($properties as $property) {
            $getter = 'get' . ucfirst($property);
            $value = $filters->$getter();
            if ($value !== null && $value !== '') {
                $queryBuilder->andWhere("cli.$property = :$property")
                    ->setParameter($property, $value);
            }
        }

        // Execute the query and return the result
        return $queryBuilder->getQuery()->getResult();
    }
    //    /**
    //     * @return Clients[] Returns an array of Clients objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Clients
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
