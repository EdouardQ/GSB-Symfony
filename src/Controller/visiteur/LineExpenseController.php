<?php

namespace App\Controller\visiteur;

use DateTime;
use App\Entity\User;
use App\Entity\LineExpenseBundle;
use App\Service\ExpenseFormUpdate;
use App\Form\LineExpenseBundleType;
use App\Entity\LineExpenseOutBundle;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LineExpenseOutBundleRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/visiteur')]

class LineExpenseController extends AbstractController
{
    private User $user;
    private LineExpenseBundleRepository $lineExpenseBundleRepository;
    private LineExpenseOutBundleRepository $lineExpenseOutBundleRepository;
    private RequestStack $requeststack; // requête de symfony
    private Request $request; // requête HTTP du navigateur
    private EntityManagerInterface $entityManager; // permet d'éxécuter insert, delete et update en sql
    private Security $security;
    private ExpenseFormRepository $expenseFormRepository; // requêtes de sélection de ExpenseForm
    private ExpenseFormUpdate $expenseFormUpdate;

    public function __construct(LineExpenseBundleRepository $lineExpenseBundleRepository,LineExpenseOutBundleRepository $lineExpenseOutBundleRepository,
        RequestStack $requeststack, EntityManagerInterface $entityManager, Security $security, ExpenseFormRepository $expenseFormRepository,
        ExpenseFormUpdate $expenseFormUpdate)
    {
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->requeststack = $requeststack;
        $this->request = $this->requeststack->getCurrentRequest();
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->expenseFormRepository = $expenseFormRepository;
        $this->expenseFormUpdate = $expenseFormUpdate;

        $this->user = $this->security->getUser(); // Récupère l'utilisateur actuel
    }

    #[Route('/ligne_frais/form_forfait/{id}', name: 'visiteur.ligne_frais.form_forfait')]

    public function form_forfait(int $id = null):Response
    {   
        $entity = $id ? $this->lineExpenseBundleRepository->find($id) : new LineExpenseBundle;
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité

        $type = LineExpenseBundleType::class;

        // création du formulaire
        $form = $this->createForm($type, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            if (!isset($id))
            {
                $currentExpenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($this->user); // Récupère la derrnière fiche frais du visiteur
                $entity->setExpenseForm($currentExpenseForm[0]); // [0] car l'objet est dans un tableau
            }

            $entity->setDate(new DateTime(date("d-m-Y")));

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('notice',  $id ? "Le Frais a bien été modifié" : "Le Frais a bien été enregistré");

            $this->expenseFormUpdate->updateExpenseForm($this->user);

            return $this->redirectToRoute('visiteur.fiche_frais.fiche_mois');
        }

        return $this->render('visiteur/ligne_frais/form_forfait.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ligne_frais/delete_forfait/{id}', name: 'visiteur.ligne_frais.delete_forfait')]

    public function delete_forfait(int $id):Response
    {
        $entity = $this->lineExpenseBundleRepository->find($id);

        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        $this->addFlash('notice', "Le Frais a bien été supprimé");

        $this->expenseFormUpdate->updateExpenseForm($this->user);
        
        return $this->redirectToRoute('visiteur.fiche_frais.fiche_mois');
    }


    #[Route('/ligne_frais/form_hors_forfait/{id}', name: 'visiteur.ligne_frais.form_hors_forfait')]

    public function form_hors_forfait(int $id = null):Response
    {
        $entity = $id ? $this->lineExpenseOutBundleRepository->find($id) : new LineExpenseOutBundle;
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité

        $type = LineExpenseOutBundleType::class;

        // création du formulaire
        $form = $this->createForm($type, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            if (!isset($id))
            {
                $currentExpenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($this->user); // Récupère la derrnière fiche frais du visiteur
                $entity->setExpenseForm($currentExpenseForm[0]); // [0] car l'objet est dans un tableau
            }

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('notice',  $id ? "Le Frais a bien été modifié" : "Le Frais a bien été enregistré");

            $this->expenseFormUpdate->updateExpenseForm($this->user);

            return $this->redirectToRoute('visiteur.fiche_frais.fiche_mois');
        }

        return $this->render('visiteur/ligne_frais/form_forfait.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}