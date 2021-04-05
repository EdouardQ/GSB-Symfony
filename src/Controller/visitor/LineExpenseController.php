<?php

namespace App\Controller\visitor;

use DateTime;
use App\Service\FileService;
use App\Entity\LineExpenseBundle;
use App\Service\ExpenseFormUpdate;
use App\Form\LineExpenseBundleType;
use App\Entity\LineExpenseOutBundle;
use App\Form\LineExpenseOutBundleType;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LineExpenseOutBundleRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visitor')]

class LineExpenseController extends AbstractController
{
    private LineExpenseBundleRepository $lineExpenseBundleRepository;
    private LineExpenseOutBundleRepository $lineExpenseOutBundleRepository;
    private ExpenseFormRepository $expenseFormRepository;
    private ExpenseFormUpdate $expenseFormUpdate;
    private FileService $fileService;

    public function __construct(LineExpenseBundleRepository $lineExpenseBundleRepository,LineExpenseOutBundleRepository $lineExpenseOutBundleRepository,
        ExpenseFormRepository $expenseFormRepository, ExpenseFormUpdate $expenseFormUpdate, FileService $fileService)
    {
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->expenseFormRepository = $expenseFormRepository;
        $this->expenseFormUpdate = $expenseFormUpdate;
        $this->fileService = $fileService;
    }

    #[Route('/lineExpense/formBundle/{id}', name: 'visitor.line_expense.form_bundle')]

    public function formBundle(int $id = null, Request $request): Response
    {   
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité
        $entity = $id ? $this->lineExpenseBundleRepository->find($id) : new LineExpenseBundle;
        
        // création du formulaire
        $form = $this->createForm(LineExpenseBundleType::class, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        // getCurrentRequest vient de AbstractController
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!isset($id)) {
                $currentExpenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($this->getUser()); // Récupère la derrnière fiche frais du visiteur
                $entity->setExpenseForm($currentExpenseForm[0]); // [0] car l'objet est dans un tableau
            }

            $entity->setDate(new DateTime(date("d-m-Y")));

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('notice',  $id ? "Le Frais a bien été modifié" : "Le Frais a bien été enregistré");

            $this->expenseFormUpdate->updateExpenseForm($this->getUser());

            return $this->redirectToRoute('visitor.expense_form.bundle_monthly');
        }

        return $this->render('visitor/lineExpense/formBundle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/lineExpense/deleteBundle/{id}', name: 'visitor.line_expense.delete_bundle')]

    public function deleteBundle(LineExpenseBundle $entity): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($entity);
        $entityManager->flush();

        $this->addFlash('notice', "Le Frais a bien été supprimé");

        $this->expenseFormUpdate->updateExpenseForm($this->getUser());
        
        return $this->redirectToRoute('visitor.expense_form.bundle_monthly');
    }


    #[Route('/lineExpense/formOutBundle/{id}', name: 'visitor.line_expense.form_out_bundle')]

    public function formOutBundle(int $id = null, Request $request): Response
    {
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité
        $entity = $id ? $this->lineExpenseOutBundleRepository->find($id) : new LineExpenseOutBundle;

        // stocker le nom du justificatif en bss dans une nouvelle propriété dynamic/temporaire
        $entity->prevSupportingDocument = $entity->getSupportingDocument();

        // création du formulaire
        $form = $this->createForm(LineExpenseOutBundleType::class, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        // getCurrentRequest vient de AbstractController
        $form->handleRequest($request);

        $dayMax = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime("now")), date("Y", strtotime("now"))); // jour maximum du mois en cours (int)

        if ($form->isSubmitted() && $form->isValid()) {   

            if (!isset($id))
            {
                $currentExpenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($this->getUser()); // Récupère la derrnière fiche frais du visiteur
                $entity->setExpenseForm($currentExpenseForm[0]); // [0] car l'objet est dans un tableau
                $entity->setValid(True);
            }
            
            // Si l'utilisateur à chargé un justificatif dans le formulaire
            if ($entity->getSupportingDocument() instanceof UploadedFile) {
            
                // utlisation du service créé
                $this->fileService->upload("../src/SupportingDocuments/", $entity->getSupportingDocument());

                // attribution du nouveau nom à l'entité
                $entity->setSupportingDocument($this->fileService->getFileName());

                // si l'entité est mise à jour, supprimer l'image précédente
                if($entity->getId() && $entity->prevSupportingDocument != null)
                {
                    //dd($entity->prevSupportingDocument);
                    $this->fileService->delete("../src/SupportingDocuments/", $entity->prevSupportingDocument);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('notice',  $id ? "Le Frais a bien été modifié" : "Le Frais a bien été enregistré");

            $this->expenseFormUpdate->updateExpenseForm($this->getUser());

            return $this->redirectToRoute('visitor.expense_form.bundle_monthly');
        }

        return $this->render('visitor/lineExpense/formOutBundle.html.twig', [
            'form' => $form->createView(),
            'dayMax' => $dayMax,
        ]);
    }

    #[Route('/lineExpense/deleteOutBundle/{id}', name: 'visitor.line_expense.delete_out_bundle')]

    public function deleteOutBundle(LineExpenseOutBundle $entity): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($entity->getSupportingDocument() != null) {
            $this->fileService->delete("../src/SupportingDocuments/", $entity->getSupportingDocument());
        }

        $entityManager->remove($entity);
        $entityManager->flush();

        $this->addFlash('notice', "Le Frais a bien été supprimé");

        $this->expenseFormUpdate->updateExpenseForm($this->getUser());
        
        return $this->redirectToRoute('visitor.expense_form.bundle_monthly');
    }
}
