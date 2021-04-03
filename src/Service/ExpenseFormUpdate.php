<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExpenseFormRepository;
use App\Repository\LineExpenseBundleRepository;
use App\Repository\LineExpenseOutBundleRepository;

class ExpenseFormUpdate
{
    private ExpenseFormRepository $expenseFormRepository;
    private LineExpenseBundleRepository $lineExpenseBundleRepository;
    private LineExpenseOutBundleRepository $lineExpenseOutBundleRepository;
    private EntityManagerInterface $entityManager; // permet d'éxécuter insert, delete et update en sql



    public function __construct(ExpenseFormRepository $expenseFormRepository, LineExpenseBundleRepository $lineExpenseBundleRepository, 
        LineExpenseOutBundleRepository $lineExpenseOutBundleRepository, EntityManagerInterface $entityManager)
    {
        $this->expenseFormRepository = $expenseFormRepository;
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->entityManager = $entityManager;
    }

    public function updateExpenseForm(User $user): void
    {
        $expenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($user)[0]; // [0] car l'objet est dans un tableau

        $lineExpenseBundleArray = $this->lineExpenseBundleRepository->findLineExpenseBundleByExpenseForm($expenseForm);
        $lineExpenseOutBundleArray = $this->lineExpenseOutBundleRepository->findLineExpenseOutBundleByExpenseForm($expenseForm);

        $nbJustificatifs = 0;
        $montantValide = 0;

        foreach ($lineExpenseBundleArray as $lineExpenseBundle) {
            $nbJustificatifs += 1;
            $montantValide += floatval($lineExpenseBundle->getQuantite()) * floatval($lineExpenseBundle->getExpenseBundle()->getMontant());
        }

        foreach ($lineExpenseOutBundleArray as $lineExpenseOutBundle) {
            $nbJustificatifs += 1;
            $montantValide += floatval($lineExpenseOutBundle->getMontant());
        }

        $expenseForm->setNbJustificatifs($nbJustificatifs);
        $expenseForm->setMontantValide($montantValide);
        $expenseForm->setDateModif(new DateTime(date("H:i:s d-m-Y")));

        $this->entityManager->flush();
    }
}
