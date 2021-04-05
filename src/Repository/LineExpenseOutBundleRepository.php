<?php

namespace App\Repository;

use App\Entity\ExpenseForm;
use App\Entity\LineExpenseOutBundle;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findLineExpenseOutBundleByExpenseForm(ExpenseForm $expenseForm) 
    {
        return $this->createQueryBuilder('Line_expense_out_bundle')
            ->join('Line_expense_out_bundle.expense_form', 'expense_form')
            ->where("Line_expense_out_bundle.expense_form = id_expense_form")
            ->setParameter('id_expense_form', $expenseForm->getId())
            ->getQuery()
            ->getResult()
        ;
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
