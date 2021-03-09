<?php

namespace App\Repository;

use App\Entity\ExpenseBundle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpenseBundle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpenseBundle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpenseBundle[]    findAll()
 * @method ExpenseBundle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseBundleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseBundle::class);
    }

    // /**
    //  * @return ExpenseBundle[] Returns an array of ExpenseBundle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExpenseBundle
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
