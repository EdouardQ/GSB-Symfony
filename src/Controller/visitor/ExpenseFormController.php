<?php

namespace App\Controller\visitor;

use App\Entity\LineExpenseOutBundle;
use App\Service\ExpenseFormCreation;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Repository\LineExpenseOutBundleRepository;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visitor')]
/**
 * Class ExpenseFormController
 *
 * Contrôleur pour toutes les pages lié aux fiches frais de la partie visiteur
 */
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
    // Génère et renvoie la page de la liste des fiches de frais
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
    // Génère et renvoie la page de création de fiche de frais pour le mois actuel
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

    #[Route('/expenseForm/bundleMonthly/displaySupportingDocument/{supportingDocument}', name: 'visitor.expense_form.bundle_monthly.display_supporting_document')]
    // Génère la page du justificatif dans un nouvel onglet
    public function displaySupportingDocument(LineExpenseOutBundle $entity, KernelInterface $kernelInterface): Response
    {   
        // charge le fichier depuis le dossier racine du projet à son emplacement dans un objet File
        $file = new File($kernelInterface->getProjectDir().'/src/SupportingDocuments/'.$entity->getSupportingDocument());

        // Affiche le contenu du fichier et ne ne force pas le téléchargement par le navigateur
        return $this->file($file, null, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
