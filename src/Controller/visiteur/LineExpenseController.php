<?php

namespace App\Controller\visiteur;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/visiteur')]

class LineExpenseController extends AbstractController
{
    #[Route('/ligne_frais/form_forfait/{id}', name: 'visiteur.ligne_frais.form_forfait')]

    public function form_forfait(int $id = null):Response
    {
        return $this->render('visiteur/ligne_frais/form_forfait.html.twig');
    }

    #[Route('/ligne_frais/form_hors_forfait/{id}', name: 'visiteur.ligne_frais.form_hors_forfait')]

    public function form_hors_forfait(int $id = null):Response
    {
        return $this->render('visiteur/ligne_frais/form_hors_forfait.html.twig');
    }
}