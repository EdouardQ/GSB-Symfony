<?php

namespace App\Controller\visitor;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/visitor')]

class HomepageController extends AbstractController
{    
    #[Route('/', name: 'visitor.homepage.index')]

    public function index():Response
    {
        $user = $this->getUser();

        return $this->render("visitor/homepage/index.html.twig",[
            'user' => $user
        ]);
    }
}