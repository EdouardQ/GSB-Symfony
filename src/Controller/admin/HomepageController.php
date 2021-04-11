<?php

namespace App\Controller\admin;

use App\Repository\MedicationRepository;
use App\Repository\PractitionerRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/admin')]
/**
 * Class HomepageController
 *
 * Contrôleur pour la page d'accueil de la partie admin
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

    #[Route('/', name: 'admin.homepage.index')]
    // Génère et renvoie la page d'accueil
    public function index(): Response
    {
        return $this->render("admin/homepage/index.html.twig");
    }

    #[Route('/listPractitioners', name: 'admin.homepage.list_practitioners')]
    // Génère et renvoie la page de la liste des practiciens
    public function listPractitioners(): Response
    {
        return $this->render("admin/homepage/practitioners.html.twig",[
            'practitionerArray' => $this->practitionerRepository->findAll(),
        ]);
    }

    #[Route('/listVisitors', name: 'admin.homepage.list_visitors')]
    // Génère et renvoie la page de la liste des visiteurs
    public function listVisitors(): Response
    {
        return $this->render("admin/homepage/visitors.html.twig", [
            'visitorArray' => $this->userRepository->findUserByRole("ROLE_VISITOR"),
        ]);
    }

    #[Route('/listAccountants', name: 'admin.homepage.list_accountants')]
    // Génère et renvoie la page de la liste des visiteurs
    public function listAccountants(): Response
    {
        return $this->render("admin/homepage/accountants.html.twig", [
            'accountantArray' => $this->userRepository->findUserByRole("ROLE_ACCOUNTANT"),
        ]);
    }

    #[Route('/listMedications', name: 'admin.homepage.list_medications')]
    // Génère et renvoie la page de la liste des médicaments
    public function listMedications(): Response
    {
        return $this->render("admin/homepage/medications.html.twig",[
            'medicationArray' => $this->medicationRepository->findAll(),
        ]);
    }
}