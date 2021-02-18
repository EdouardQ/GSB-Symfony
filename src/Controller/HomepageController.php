<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    /**
    * @Route("/", name="homepage.index") 
    */

    public function index():Response
    {
        return $this->render("homepage/index.html.twig");
    }
}