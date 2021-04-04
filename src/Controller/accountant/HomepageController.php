<?php

namespace App\Controller\accountant;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accountant')]
class HomepageController extends AbstractController
{

    #[Route('/', name: 'accountant.homepage.index')]
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render("accountant/homepage/index.html.twig", [
            'user' => $user
        ]);
    }     
}
