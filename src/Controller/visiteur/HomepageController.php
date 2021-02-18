<?php

namespace App\Controller\visiteur;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends AbstractController
{
    private UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }
    
    /**
     * @Route("/visiteur/", name="visiteur.homepage.index")
    */
    public function index():Response
    {
        $user = $this->getUser();

        return $this->render("visiteur/homepage/index.html.twig",[
            'user' => $user
        ]);
    }
}