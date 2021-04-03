<?php

namespace App\Controller\admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class HomepageController extends AbstractController{

    private UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository){
        $this->UserRepository = $UserRepository;
    }

    #[Route('/', name: 'admin.homepage.index')]
    public function index() :Response{
        $user = $this->getUser();

        return $this->render("admin/homepage/index.html.twig", [
            'user' => $user
        ]);
    }     
}
