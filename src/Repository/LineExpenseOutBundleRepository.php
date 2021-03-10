<?php

namespace App\Repository;

use App\Entity\LineExpenseOutBundle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LineExpenseOutBundle|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineExpenseOutBundle|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineExpenseOutBundle[]    findAll()
 * @method LineExpenseOutBundle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineExpenseOutBundleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineExpenseOutBundle::class);
    }

    // /**
    //  * @return LineExpenseOutBundle[] Returns an array of LineExpenseOutBundle objects
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
    public function findOneBySomeField($value): ?LineExpenseOutBundle
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
