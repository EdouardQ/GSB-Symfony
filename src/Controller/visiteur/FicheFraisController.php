<?php


namespace App\Controller\visiteur;

use App\Repository\ExpenseFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheFraisController extends AbstractController{
    private ExpenseFormRepository $expenseFormRepository;

    public function __construct(ExpenseFormRepository $expenseFormRepository){
        $this->expenseFormRepository = $expenseFormRepository;
    }

    #[Route('/visiteur/fiche_frais/index', name: 'visiteur.fiche_frais.index')]

    public function index():Response{

        // sélection de tous les fiches frais
        $expenseformrepository = $this->expenseFormRepository->findAll();

        // affichage de la vue
        return $this->render('visiteur/fiche_frais/index.html.twig',[
            'expenseform' => $expenseformrepository
        ]);
    }

}