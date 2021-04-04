<?php

namespace App\Controller\visitor;

use App\Service\ExpenseFormCreation;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LineExpenseOutBundleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visitor')]

class ExpenseFormController extends AbstractController{
    private ExpenseFormRepository $expenseFormRepository;
    private ExpenseFormCreation $expenseFormCreation;
    private LineExpenseBundleRepository $lineExpenseBundleRepository;
    private LineExpenseOutBundleRepository $lineExpenseOutBundleRepository;

    public function __construct(
        ExpenseFormRepository $expenseFormRepository, ExpenseFormCreation $expenseFormCreation,
        LineExpenseBundleRepository $lineExpenseBundleRepository, LineExpenseOutBundleRepository $lineExpenseOutBundleRepository)
    {
        $this->expenseFormRepository = $expenseFormRepository;
        $this->expenseFormCreation = $expenseFormCreation;
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
    }

    #[Route('/expenseForm/index', name: 'visitor.expense_form.index')]

    public function index(): Response
    {
        // sélection de tous les fiches frais
        $expenseformrepository = $this->expenseFormRepository->findBy(['user' => $this->getUser()]);

        // affichage de la vue
        return $this->render('visitor/expenseForm/index.html.twig',[
            'expenseform' => $expenseformrepository
        ]);
    }

    #[Route('/expenseForm/bundleMonthly', name: 'visitor.expense_form.bundle_monthly')]

    public function bundleMonthly(): Response
    {   
        $user = $this->getUser(); // Récupère l'utilisateur actuel
        $month = date("m-Y"); // Récupère la date sous la forme "01-2021"

        $entity = $this->expenseFormRepository->findExpenseFormByUserAndMonth($month, $user); // Récupère la derrnière fiche frais du visiteur ou renvoie null

        // S'il n'existe pas de fiche frais pour ce mois pour ce visiteur, on en crée un automatiquement
        if ($entity == null) {
            $entity = $this->expenseFormCreation->creation($user, $month);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($entity);
            $entityManager->flush();
        } 
        else {
            // extraction de l'entité du tableau créé par la requête sql
            $entity = $entity[0]; 
        }
        
        $lineExpenseBundleArray = $this->lineExpenseBundleRepository->findLineExpenseBundleByExpenseForm($entity);
        $lineExpenseOutBundleArray = $this->lineExpenseOutBundleRepository->findLineExpenseOutBundleByExpenseForm($entity);
        
        return $this->render('visitor/expenseForm/bundleMonthly.html.twig', [
            'bundleMonthly' => $entity,
            'lineExpenseBundleArray' => $lineExpenseBundleArray,
            'lineExpenseOutBundleArray' => $lineExpenseOutBundleArray,
        ]);
    }

}