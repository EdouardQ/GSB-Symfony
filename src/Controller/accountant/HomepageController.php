<?php

namespace App\Controller\accountant;

use App\Service\ExpenseFormUpdate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/accountant')]
/**
 * Class HomepageController
 *
 * Contrôleur pour la page d'accueil de la partie comptable
 */
class HomepageController extends AbstractController
{
    private ExpenseFormUpdate $expenseFormUpdate;

    public function __construct(ExpenseFormUpdate $expenseFormUpdate)
    {
        $this->expenseFormUpdate = $expenseFormUpdate;
    }

    #[Route('/', name: 'accountant.homepage.index')]
    // Génère et renvoie la page d'accueil
    public function index(): Response
    {
        // ferme toutes les fiches frais qui sont encore ouvertes et qui ne datent pas du mois en cours
        $this->expenseFormUpdate->closeAllInProgressExpenseForm();

        return $this->render("accountant/homepage/index.html.twig", [
            'user' => $this->getUser(),
        ]);
    }     
}
