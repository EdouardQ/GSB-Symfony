<?php

namespace App\Controller\accountant;

use App\Repository\StateRepository;
use App\Service\ExpenseFormCreation;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LineExpenseOutBundleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/accountant')]
class ExpenseFormController extends AbstractController
{
    private ExpenseFormRepository $expenseFormRepository;
    private StateRepository $stateRepository;

    public function __construct(ExpenseFormRepository $expenseFormRepository,ExpenseFormCreation $expenseFormCreation,
    LineExpenseBundleRepository $lineExpenseBundleRepository, LineExpenseOutBundleRepository $lineExpenseOutBundleRepository, StateRepository $stateRepository)
    {
        $this->expenseFormRepository = $expenseFormRepository;
        $this->expenseFormCreation = $expenseFormCreation;
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->stateRepository = $stateRepository;
    }

    #[Route('/expenseForm/listExpenseFormLeft', name: 'accountant.expense_form.list_expense_form_left')]
    public function listExpenseFormLeft(): Response
    {
        $state_cloture = $this->stateRepository->findBy(['wording' => 'Saisie clôturée']);

        // Sélection de tous les fiches frais restant à valider ou refusé
        $expenseformrepository = $this->expenseFormRepository->findBy(['state' => $state_cloture]);

        // affichage de la vue
        return $this->render('accountant/expenseForm/listExpenseFormLeft.html.twig', [
            'expenseform' => $expenseformrepository
        ]);
    }

    #[Route('expenseForm/listExpenseFormTreated', name: 'accountant.expense_form.list_expense_form_treated')]
    public function listExpenseFormTreated(): Response
    {
        $stateReimbursed = $this->stateRepository->findBy(['wording' => "Remboursée"])[0];
        $stateValidated = $this->stateRepository->findBy(['wording' => "Validée et mise en paiement"])[0];

        // Sélection de tous les fiches frais restant à valider ou refusé
        $expenseformrepository = $this->expenseFormRepository->getExpenseFormTreated($stateReimbursed, $stateValidated);

        // affichage de la vue
        return $this->render('accountant/expenseForm/listExpenseFormTreated.html.twig', [
            'expenseform' => $expenseformrepository
        ]);
    }

}
