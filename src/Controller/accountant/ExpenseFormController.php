<?php

namespace App\Controller\accountant;

use App\Repository\ExpenseFormRepository;
use App\Repository\LineExpenseBundleRepository;
use App\Repository\LineExpenseOutBundleRepository;
use App\Repository\StateRepository;
use App\Service\ExpenseFormCreation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/accountant')]
class ExpenseFormController extends AbstractController
{
    private ExpenseFormRepository $expenseFormRepository;
    private RequestStack $requeststack;
    private Request $request;
    private EntityManagerInterface $entityManager;
    private Security $security;
    private ExpenseFormCreation $expenseFormCreation;
    private LineExpenseBundleRepository $lineExpenseBundleRepository;
    private LineExpenseOutBundleRepository $lineExpenseOutBundleRepository;
    private StateRepository $stateRepository;

    public function __construct(ExpenseFormRepository $expenseFormRepository, RequestStack $requeststack, EntityManagerInterface $entityManager, Security $security,
        ExpenseFormCreation $expenseFormCreation, LineExpenseBundleRepository $lineExpenseBundleRepository, LineExpenseOutBundleRepository $lineExpenseOutBundleRepository, StateRepository $stateRepository)
        {
        $this->expenseFormRepository = $expenseFormRepository;
        $this->requeststack = $requeststack;
        $this->request = $this->requeststack->getCurrentRequest();
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->expenseFormCreation = $expenseFormCreation;
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->stateRepository = $stateRepository;
    }

    #[Route('/expenseForm/listExpenseFormLeft', name: 'accountant.expenseForm.listExpenseFormLeft')]
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

    #[Route('expenseForm/listExpenseFormTreated', name: 'accountant.expenseForm.listExpenseFormTreated')]
    public function listExpenseFormTreated(): Response
    {

        // Sélection de tous les fiches frais restant à valider ou refusé
        $expenseformrepository = $this->expenseFormRepository->getExpenseFormTreated();

        // affichage de la vue
        return $this->render('accountant/expenseForm/listExpenseFormTreated.html.twig', [
            'expenseform' => $expenseformrepository
        ]);
    }

}
