<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\ExpenseForm;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findExpenseFormByUserAndMonth($month, User $user)
    {
        return $this->createQueryBuilder('expense_form')
            ->join('expense_form.user', 'user')
            ->where("user = ".$user->getId())
            ->andWhere("expense_form.month = '$month'")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findTheLastExpenseFormByUser(User $user)
    {
        $month = date("m-Y"); // Récupère la date sous la forme "01-2021"

        return $this->createQueryBuilder('expense_form')
            ->join('expense_form.user', 'user')
            ->where("user = ".$user->getId())
            ->andWhere("expense_form.month = '$month'")
            ->getQuery()
            ->getResult()
        ;
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
