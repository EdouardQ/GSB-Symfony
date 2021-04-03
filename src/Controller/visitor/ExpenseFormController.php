<?php

namespace App\Controller\visiteur;

use App\Service\ExpenseFormCreation;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LineExpenseOutBundleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visiteur')]

class ExpenseFormController extends AbstractController{
    private ExpenseFormRepository $expenseFormRepository; // requêtes de sélection de ExpenseForm
    private EntityManagerInterface $entityManager; // permet d'éxécuter insert, delete et update en sql
    private Security $security;
    private ExpenseFormCreation $expenseFormCreation;
    private LineExpenseBundleRepository $lineExpenseBundleRepository;
    private LineExpenseOutBundleRepository $lineExpenseOutBundleRepository;


    public function __construct(
        ExpenseFormRepository $expenseFormRepository, EntityManagerInterface $entityManager, Security $security,
        ExpenseFormCreation $expenseFormCreation, LineExpenseBundleRepository $lineExpenseBundleRepository, LineExpenseOutBundleRepository $lineExpenseOutBundleRepository)
        {
        $this->expenseFormRepository = $expenseFormRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->expenseFormCreation = $expenseFormCreation;
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
    }

    #[Route('/fiche_frais/index', name: 'visiteur.fiche_frais.index')]

    public function index():Response
    {
        $user = $this->security->getUser(); // Récupère l'utilisateur actuel

        // sélection de tous les fiches frais
        $expenseformrepository = $this->expenseFormRepository->findBy(['user' => $user]);

        // affichage de la vue
        return $this->render('visiteur/fiche_frais/index.html.twig',[
            'expenseform' => $expenseformrepository
        ]);
    }

    #[Route('/fiche_frais/fiche_mois', name: 'visiteur.fiche_frais.fiche_mois')]

    public function fiche_mois():Response
    {   
        $user = $this->security->getUser(); // Récupère l'utilisateur actuel
        $month = date("m-Y"); // Récupère la date sous la forme "01-2021"

        $entity = $this->expenseFormRepository->findExpenseFormByUserAndMonth($month, $user); // Récupère la derrnière fiche frais du visiteur ou renvoie null

        if ($entity == null) // S'il n'existe pas de fiche frais pour ce mois pour ce visiteur, on en crée un automatiquement
        {
            $entity = $this->expenseFormCreation->creation($user, $month);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
        else
        {
            $entity = $entity[0]; // extraction de l'entité du tableau créé par la requête sql
        }
        
        $lineExpenseBundleArray = $this->lineExpenseBundleRepository->findLineExpenseBundleByExpenseForm($entity);
        $lineExpenseOutBundleArray = $this->lineExpenseOutBundleRepository->findLineExpenseOutBundleByExpenseForm($entity);
        
        return $this->render('visiteur/fiche_frais/fiche_mois.html.twig', [
            'fiche_frais' => $entity,
            'lineExpenseBundleArray' => $lineExpenseBundleArray,
            'lineExpenseOutBundleArray' => $lineExpenseOutBundleArray,
        ]);
    }

}