<?php

namespace App\Repository;

use App\Entity\Cupcake;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cupcake>
 */
class CupcakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cupcake::class);
    }

    public function findFour(): array
   {
       return $this->createQueryBuilder('c')
            ->leftJoin('c.colors', 'co')
            ->addSelect('co')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults( 4 )
            ->getQuery()
            ->getResult()
        ;
   }

//    /**
//     * @return Cupcake[] Returns an array of Cupcake objects
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

//    public function findOneBySomeField($value): ?Cupcake
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
