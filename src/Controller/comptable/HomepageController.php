<?php

namespace App\Controller\comptable;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comptable')]
class HomepageController extends AbstractController{

    private UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository){
        $this->UserRepository = $UserRepository;
    }

    #[Route('/', name: 'comptable.homepage.index')]
    public function index() :Response{
        $user = $this->getUser();

        return $this->render("comptable/homepage/index.html.twig", [
            'user' => $user
        ]);
    }     
}
