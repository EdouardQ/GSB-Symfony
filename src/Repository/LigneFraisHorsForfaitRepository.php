<?php

namespace App\Repository;

use App\Entity\LigneFraisHorsForfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneFraisHorsForfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneFraisHorsForfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneFraisHorsForfait[]    findAll()
 * @method LigneFraisHorsForfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneFraisHorsForfaitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneFraisHorsForfait::class);
    }

    // /**
    //  * @return LigneFraisHorsForfait[] Returns an array of LigneFraisHorsForfait objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneFraisHorsForfait
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
