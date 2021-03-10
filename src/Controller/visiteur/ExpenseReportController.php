<?php

namespace App\Controller\visiteur;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ExpenseReportController extends AbstractController
{

    #[Route('/visiteur/expense_report_display', name: 'visiteur.expensereport.displayreports')]

    public function displayreports():Response
    {
        return $this->render("visiteur/expensereport/displayreports.html.twig");
    }
}