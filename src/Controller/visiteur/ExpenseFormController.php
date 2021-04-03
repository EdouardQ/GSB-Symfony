<?php


namespace App\Controller\visiteur;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Request;
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


    public function __construct(ExpenseFormRepository $expenseFormRepository, RequestStack $requeststack, EntityManagerInterface $entityManager){
        $this->expenseFormRepository = $expenseFormRepository;
        $this->requeststack = $requeststack;
        $this->request = $this->requeststack->getCurrentRequest();
        $this->entityManager = $entityManager;
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

    #[Route('/fiche_frais/form', name: 'visiteur.fiche_frais.form')]

    public function form():Response
    {
        return $this->render('visiteur/fiche_frais/form.html.twig');
    }

}