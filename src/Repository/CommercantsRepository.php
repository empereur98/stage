<?php

namespace App\Repository;

use App\Entity\Commercants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commercants>
 *
 * @method Commercants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commercants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commercants[]    findAll()
 * @method Commercants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommercantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commercants::class);
    }

//    /**
//     * @return Commercants[] Returns an array of Commercants objects
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

//    public function findOneBySomeField($value): ?Commercants
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
