<?php

namespace App\Controller\visitor;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/visitor')]

class HomepageController extends AbstractController
{    
    #[Route('/', name: 'visitor.homepage.index')]

    public function index(): Response
    {
        return $this->render("visitor/homepage/index.html.twig");
    }
}