<?php

namespace App\Controller\accountant;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/accountant')]
class HomepageController extends AbstractController
{
    #[Route('/', name: 'accountant.homepage.index')]
    public function index(): Response
    {
        return $this->render("accountant/homepage/index.html.twig", [
            'user' => $this->getUser(),
        ]);
    }     
}
