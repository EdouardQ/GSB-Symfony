<?php


namespace App\Controller\visiteur;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExpenseFormRepository;
use App\Service\ExpenseFormCreation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visiteur')]

class ExpenseFormController extends AbstractController{
    private ExpenseFormRepository $expenseFormRepository; // requêtes de sélection de ExpenseForm
    private RequestStack $requeststack; // requête de symfony
    private Request $request; // requête HTTP du navigateur
    private EntityManagerInterface $entityManager; // permet d'éxécuter insert, delete et update en sql
    private Security $security;
    private ExpenseFormCreation $expenseFormCreation;


    public function __construct(
        ExpenseFormRepository $expenseFormRepository, RequestStack $requeststack, EntityManagerInterface $entityManager, Security $security, ExpenseFormCreation $expenseFormCreation)
        {
        $this->expenseFormRepository = $expenseFormRepository;
        $this->requeststack = $requeststack;
        $this->request = $this->requeststack->getCurrentRequest();
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->expenseFormCreation = $expenseFormCreation;
    }

    #[Route('/fiche_frais/index', name: 'visiteur.fiche_frais.index')]

    public function index():Response
    {
        // sélection de tous les fiches frais
        $expenseformrepository = $this->expenseFormRepository->findAll();

        // affichage de la vue
        return $this->render('visiteur/fiche_frais/index.html.twig',[
            'expenseform' => $expenseformrepository
        ]);
    }

    #[Route('/fiche_frais/fiche_actuelle', name: 'visiteur.fiche_frais.fiche_actuelle')]

    public function fiche_actuelle():Response
    {   
        $user = $this->security->getUser(); // Récupére l'utilisateur actuel
        $month = date("m-Y"); // Récupére la date sous la forme "01-2021"

        $result = $this->expenseFormRepository->findExpenseFormByUserAndMonth($month, $user); // Récupére la derrnière fiche frais du visiteur ou renvoie null

        if ($result == null) // S'il n'existe pas de fiche frais pour ce mois pour ce visiteur, on en crée un automatiquement
        {
            $entity = $this->expenseFormCreation->creation($user, $month);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
        

        return $this->render('visiteur/fiche_frais/fiche_actuelle.html.twig');
    }

}