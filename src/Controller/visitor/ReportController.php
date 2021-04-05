<?php

namespace App\Controller\visitor;

use App\Entity\Report;
use App\Form\ReportType;
use App\Entity\SamplesOffer;
use App\Form\SamplesOfferType;
use App\Repository\ReportRepository;
use App\Repository\SamplesOfferRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visitor')]

class ReportController extends AbstractController
{
    private ReportRepository $reportRepository;
    private SamplesOfferRepository $samplesOfferRepository;

    public function __construct(ReportRepository $reportRepository, SamplesOfferRepository $samplesOfferRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->samplesOfferRepository = $samplesOfferRepository;
    }

    #[Route('/report', name: 'visitor.report.index')]

    public function index(): Response
    {
        $reportArray = $this->reportRepository->findby(['user' => $this->getUser()]);

        return $this->render('visitor/report/index.html.twig', [
            'reportArray' => $reportArray,
        ]);
    }

    #[Route('/report/create', name: 'visitor.report.create')]

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

            $this->addFlash('noticeReport', "Le compte-rendu a bien été enregistré.");

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

            $this->addFlash('noticeBis', "La saisie des échantillons a bien été enregistrée.");

            return $this->redirectToRoute('visitor.report.samples_offer_form', ['id'=> $report->getId()]);     
        }

        return $this->render('visitor/report/samplesOfferForm.html.twig', [
            'form' => $form->createView(),
            'numReport' => $report->getId(),
        ]);
    }

    #[Route('/report/consult/{id}', name: 'visitor.report.consult')]

    public function consult(Report $entity): Response
    {
        if($entity->getUser() === $this->getUser()) {

            $samplesOfferArray = $this->samplesOfferRepository->findBy(['report' => $entity]);

            return $this->render('visitor/report/consult.html.twig', [
                'report' => $entity,
                'samplesOfferArray' => $samplesOfferArray,
            ]);
        }
        return $this->redirectToRoute('visitor.report.index');
    }

}
