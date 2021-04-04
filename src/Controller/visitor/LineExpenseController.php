<?php

namespace App\Controller\visitor;

use DateTime;
use App\Entity\LineExpenseBundle;
use App\Service\ExpenseFormUpdate;
use App\Form\LineExpenseBundleType;
use App\Entity\LineExpenseOutBundle;
use App\Form\LineExpenseOutBundleType;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LineExpenseOutBundleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visitor')]

class LineExpenseController extends AbstractController
{
    private LineExpenseBundleRepository $lineExpenseBundleRepository;
    private LineExpenseOutBundleRepository $lineExpenseOutBundleRepository;
    private ExpenseFormRepository $expenseFormRepository; // requêtes de sélection de ExpenseForm
    private ExpenseFormUpdate $expenseFormUpdate;

    public function __construct(LineExpenseBundleRepository $lineExpenseBundleRepository,LineExpenseOutBundleRepository $lineExpenseOutBundleRepository,
        ExpenseFormRepository $expenseFormRepository, ExpenseFormUpdate $expenseFormUpdate)
    {
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->expenseFormRepository = $expenseFormRepository;
        $this->expenseFormUpdate = $expenseFormUpdate;
    }

    #[Route('/lineExpense/formBundle/{id}', name: 'visitor.lineExpense.formBundle')]

    public function formBundle(int $id = null): Response
    {   
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité
        $entity = $id ? $this->lineExpenseBundleRepository->find($id) : new LineExpenseBundle;
        
        // création du formulaire
        $form = $this->createForm(LineExpenseBundleType::class, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        // getCurrentRequest vient de AbstractController
        $form->handleRequest($this->container->get('request_stack')->getCurrentRequest());

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

            return $this->redirectToRoute('visitor.expenseForm.bundleMonthly');
        }

        return $this->render('visitor/lineExpense/formBundle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/lineExpense/deleteBundle/{id}', name: 'visitor.lineExpense.deleteBundle')]

    public function deleteBundle(LineExpenseBundle $entity):Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($entity);
        $entityManager->flush();

        $this->addFlash('notice', "Le Frais a bien été supprimé");

        $this->expenseFormUpdate->updateExpenseForm($this->getUser());
        
        return $this->redirectToRoute('visitor.expenseForm.bundleMonthly');
    }


    #[Route('/lineExpense/formOutBundle/{id}', name: 'visitor.lineExpense.formOutBundle')]

    public function formOutBundle(int $id = null): Response
    {
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité
        $entity = $id ? $this->lineExpenseOutBundleRepository->find($id) : new LineExpenseOutBundle;

        // création du formulaire
        $form = $this->createForm(LineExpenseOutBundleType::class, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        // getCurrentRequest vient de AbstractController
        $form->handleRequest($this->container->get('request_stack')->getCurrentRequest());

        $dayMax = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime("now")), date("Y", strtotime("now"))); // jour maximum du mois en cours (int)

        if ($form->isSubmitted() && $form->isValid()) {   

            if (!isset($id))
            {
                $currentExpenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($this->getUser()); // Récupère la derrnière fiche frais du visiteur
                $entity->setExpenseForm($currentExpenseForm[0]); // [0] car l'objet est dans un tableau
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('notice',  $id ? "Le Frais a bien été modifié" : "Le Frais a bien été enregistré");

            $this->expenseFormUpdate->updateExpenseForm($this->getUser());

            return $this->redirectToRoute('visitor.expenseForm.bundleMonthly');
        }

        return $this->render('visitor/lineExpense/formOutBundle.html.twig', [
            'form' => $form->createView(),
            'dayMax' => $dayMax,
        ]);
    }

    #[Route('/lineExpense/deleteOutBundle/{id}', name: 'visitor.lineExpense.deleteOutBundle')]

    public function deleteOutBundle(LineExpenseOutBundle $entity):Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($entity);
        $entityManager->flush();

        $this->addFlash('notice', "Le Frais a bien été supprimé");

        $this->expenseFormUpdate->updateExpenseForm($this->getUser());
        
        return $this->redirectToRoute('visitor.expenseForm.bundleMonthly');
    }


}
