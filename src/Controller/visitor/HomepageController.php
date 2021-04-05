<?php

namespace App\Controller\visitor;

use App\Repository\MedicationRepository;
use App\Repository\PractitionerRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/visitor')]

class HomepageController extends AbstractController
{
    private UserRepository $userRepository;
    private PractitionerRepository $practitionerRepository;
    private MedicationRepository $medicationRepository;

    public function __construct(UserRepository $userRepository, PractitionerRepository $practitionerRepository, MedicationRepository $medicationRepository)
    {
        $this->userRepository = $userRepository;
        $this->practitionerRepository = $practitionerRepository;
        $this->medicationRepository = $medicationRepository;
    }

    #[Route('/', name: 'visitor.homepage.index')]

    public function index(): Response
    {
        return $this->render("visitor/homepage/index.html.twig");
    }

    #[Route('/listPractitioners', name: 'visitor.homepage.list_practitioners')]

    public function listPractitioners(): Response
    {
        return $this->render("visitor/homepage/practitioners.html.twig",[
            'practitionerArray' => $this->practitionerRepository->findAll(),
        ]);
    }

    #[Route('/listVisitors', name: 'visitor.homepage.list_visitors')]

    public function listVisitors(): Response
    {
        return $this->render("visitor/homepage/visitors.html.twig", [
            'visitorArray' => $this->userRepository->findUserByRole("ROLE_VISITOR"),
        ]);
    }

    #[Route('/listMedications', name: 'visitor.homepage.list_medications')]

    public function listMedications(): Response
    {
        return $this->render("visitor/homepage/medications.html.twig",[
            'medicationArray' => $this->medicationRepository->findAll(),
        ]);
    }
}