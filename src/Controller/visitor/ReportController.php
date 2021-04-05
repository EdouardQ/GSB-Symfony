<?php

namespace App\Controller\visitor;

use App\Entity\Report;
use App\Entity\SamplesOffer;
use App\Form\ReportType;
use App\Form\SamplesOfferType;
use App\Repository\ReportRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/visitor')]

class ReportController extends AbstractController
{
    private ReportRepository $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;    
    }

    #[Route('/report', name: 'visitor.report.index')]

    public function index(): Response
    {
        $reportArray = $this->reportRepository->findby(['user' => $this->getUser()]);

        return $this->render('visitor/report/index.html.twig', [
            'reportArray' => $reportArray,
        ]);
    }

    #[Route('/report/create', name: 'visitor.report.index')]

    public function create(Request $request): Response
    {
        $entity = new Report;
        $form = $this->createForm(ReportType::class, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        // getCurrentRequest vient de AbstractController
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {   
            $entity->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirectToRoute('visitor.report.samples_offer_form', ['id'=> $entity->getId()]);      
        }

        return $this->render('visitor/report/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/report/create/samplesOfferForm/{id}', name: 'visitor.report.samples_offer_form')]

    public function samplesOfferForm(Report $report, Request $request): Response
    {
        $entity = new SamplesOffer;
        $entity->setReport($report);

        $form = $this->createForm(SamplesOfferType::class, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        // getCurrentRequest vient de AbstractController
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {   

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('notice', "Le compte-rendu a bien été enregistré");

            return $this->redirectToRoute('visitor.report.samples_offer_form', ['id'=> $report->getId()]);     
        }

        return $this->render('visitor/report/samplesOfferForm.html.twig', [
            'form' => $form->createView(),
            'numReport' => $report->getId(),
        ]);
    }

}
