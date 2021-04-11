<?php

namespace App\Controller\visitor;

use App\Repository\MedicationRepository;
use App\Repository\PractitionerRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/visitor')]
/**
 * Class HomepageController
 *
 * Contrôleur pour la page d'accueil de la partie visiteur
 */
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
    // Génère et renvoie la page d'accueil
    public function index(): Response
    {
        return $this->render("visitor/homepage/index.html.twig");
    }

    #[Route('/listPractitioners', name: 'visitor.homepage.list_practitioners')]
    // Génère et renvoie la page de la liste des practiciens
    public function listPractitioners(): Response
    {
        return $this->render("visitor/homepage/practitioners.html.twig",[
            'practitionerArray' => $this->practitionerRepository->findAll(),
        ]);
    }

    #[Route('/listVisitors', name: 'visitor.homepage.list_visitors')]
    // Génère et renvoie la page de la liste des visiteurs
    public function listVisitors(): Response
    {
        return $this->render("visitor/homepage/visitors.html.twig", [
            'visitorArray' => $this->userRepository->findCurrentUserByRole("ROLE_VISITOR"),
        ]);
    }

    #[Route('/listMedications', name: 'visitor.homepage.list_medications')]
    // Génère et renvoie la page de la liste des médicaments
    public function listMedications(): Response
    {
        return $this->render("visitor/homepage/medications.html.twig",[
            'medicationArray' => $this->medicationRepository->findAll(),
        ]);
    }
}