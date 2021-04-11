<?php

namespace App\Service;

use App\Entity\ExpenseForm;
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
            $montantValide += floatval($lineExpenseBundle->getQuantity()) * floatval($lineExpenseBundle->getExpenseBundle()->getAmount());
        }

        foreach ($lineExpenseOutBundleArray as $lineExpenseOutBundle) {
            if ($lineExpenseOutBundle->getSupportingDocument() !== null) {
                $nbJustificatifs += 1;
            }
            $montantValide += floatval($lineExpenseOutBundle->getAmount());
        }

        $expenseForm->setNbSupportingDocuments($nbJustificatifs);
        $expenseForm->setValidAmount($montantValide);
        $expenseForm->setDateUpdate(new DateTime(date("H:i:s d-m-Y")));

        $this->entityManager->flush();
    }

    public function updateExpenseFormAmount(ExpenseForm $entity): void
    {
        $lineExpenseBundleArray = $this->lineExpenseBundleRepository->findLineExpenseBundleByExpenseForm($entity);
        $lineExpenseOutBundleArray = $this->lineExpenseOutBundleRepository->findLineExpenseOutBundleByExpenseForm($entity);

        $montantValide = 0;

        foreach ($lineExpenseBundleArray as $lineExpenseBundle) {
            $montantValide += floatval($lineExpenseBundle->getQuantity()) * floatval($lineExpenseBundle->getExpenseBundle()->getAmount());
        }

        foreach ($lineExpenseOutBundleArray as $lineExpenseOutBundle) {
            if ($lineExpenseOutBundle->getValid()) {
                $montantValide += floatval($lineExpenseOutBundle->getAmount());
            }
        }

        $entity->setValidAmount($montantValide);
        $entity->setDateUpdate(new DateTime(date("H:i:s d-m-Y")));

        $this->entityManager->flush();
    }
}
