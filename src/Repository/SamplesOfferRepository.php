<?php

namespace App\Repository;

use App\Entity\SamplesOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SamplesOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SamplesOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SamplesOffer[]    findAll()
 * @method SamplesOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SamplesOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SamplesOffer::class);
    }

    // /**
    //  * @return SamplesOffer[] Returns an array of SamplesOffer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SamplesOffer
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
