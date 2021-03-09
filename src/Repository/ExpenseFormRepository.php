<?php

namespace App\Repository;

use App\Entity\ExpenseForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpenseForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpenseForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpenseForm[]    findAll()
 * @method ExpenseForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseForm::class);
    }

    // /**
    //  * @return ExpenseForm[] Returns an array of ExpenseForm objects
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
    public function findOneBySomeField($value): ?ExpenseForm
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
