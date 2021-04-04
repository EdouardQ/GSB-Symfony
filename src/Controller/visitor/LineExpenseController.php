<?php

namespace App\Controller\visitor;

use DateTime;
use App\Entity\User;
use App\Service\ValidationDate;
use App\Entity\LineExpenseBundle;
use App\Service\ExpenseFormUpdate;
use App\Form\LineExpenseBundleType;
use App\Entity\LineExpenseOutBundle;
use App\Form\LineExpenseOutBundleType;
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

#[Route('/visitor')]

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
    private ValidationDate $validationDate;

    public function __construct(LineExpenseBundleRepository $lineExpenseBundleRepository,LineExpenseOutBundleRepository $lineExpenseOutBundleRepository,
        RequestStack $requeststack, EntityManagerInterface $entityManager, Security $security, ExpenseFormRepository $expenseFormRepository,
        ExpenseFormUpdate $expenseFormUpdate, ValidationDate $validationDate)
    {
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->requeststack = $requeststack;
        $this->request = $this->requeststack->getCurrentRequest();
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->expenseFormRepository = $expenseFormRepository;
        $this->expenseFormUpdate = $expenseFormUpdate;
        $this->validationDate = $validationDate;    

        $this->user = $this->security->getUser(); // Récupère l'utilisateur actuel
    }

    #[Route('/lineExpense/formBundle/{id}', name: 'visitor.lineExpense.formBundle')]

    public function formBundle(int $id = null): Response
    {   
        $entity = $id ? $this->lineExpenseBundleRepository->find($id) : new LineExpenseBundle;
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité

        $type = LineExpenseBundleType::class;

        // création du formulaire
        $form = $this->createForm($type, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!isset($id)) {
                $currentExpenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($this->user); // Récupère la derrnière fiche frais du visiteur
                $entity->setExpenseForm($currentExpenseForm[0]); // [0] car l'objet est dans un tableau
            }

            $entity->setDate(new DateTime(date("d-m-Y")));

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('notice',  $id ? "Le Frais a bien été modifié" : "Le Frais a bien été enregistré");

            $this->expenseFormUpdate->updateExpenseForm($this->user);

            return $this->redirectToRoute('visitor.expenseForm.bundleMonthly');
        }

        return $this->render('visitor/lineExpense/form_forfait.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/lineExpense/deleteBundle/{id}', name: 'visitor.lineExpense.deleteBundle')]

    public function deleteBundle(int $id):Response
    {
        $entity = $this->lineExpenseBundleRepository->find($id);

        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        $this->addFlash('notice', "Le Frais a bien été supprimé");

        $this->expenseFormUpdate->updateExpenseForm($this->user);
        
        return $this->redirectToRoute('visitor.expenseForm.bundleMonthly');
    }


    #[Route('/lineExpense/formOutBundle/{id}', name: 'visitor.lineExpense.formOutBundle')]

    public function formOutBundle(int $id = null): Response
    {
        $entity = $id ? $this->lineExpenseOutBundleRepository->find($id) : new LineExpenseOutBundle;
        // Si la méthode récupère un id, elle charge l'entité reliée à l'id, sinon elle instancie une nouvelle entité

        $type = LineExpenseOutBundleType::class;

        // création du formulaire
        $form = $this->createForm($type, $entity);

        // handleRequest : récupérer la saisie dans la requête HTTP, utilisation du $_POST
        $form->handleRequest($this->request);

        $dayMax = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime("now")), date("Y", strtotime("now"))); // jour maximum du mois en cours (int)

        if ($form->isSubmitted() && $form->isValid()) {   
            $verifInputDate = $this->validationDate->validationDatelineExpenseOutBundleForm($entity); // vérifie si la date entrée dans le formulaire est valide et renvoie un bool

            if (!$verifInputDate) // condition pour la redirection en cas d'erreur dans la date
            {
                $this->addFlash('notice',  "La date n'est pas valide"); // envoie le message qui servira de message d'erreur
                if (isset($id))
                {
                    return $this->redirectToRoute('visitor.lineExpense.formOutBundle', ["id" => $id]); // avec le paramètre id
                }
                return $this->redirectToRoute('visitor.lineExpense.formOutBundle'); // sans le paramètre id
            }

            if (!isset($id))
            {
                $currentExpenseForm = $this->expenseFormRepository->findTheLastExpenseFormByUser($this->user); // Récupère la derrnière fiche frais du visiteur
                $entity->setExpenseForm($currentExpenseForm[0]); // [0] car l'objet est dans un tableau
            }

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('notice',  $id ? "Le Frais a bien été modifié" : "Le Frais a bien été enregistré");

            $this->expenseFormUpdate->updateExpenseForm($this->user);

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
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        $this->addFlash('notice', "Le Frais a bien été supprimé");

        $this->expenseFormUpdate->updateExpenseForm($this->user);
        
        return $this->redirectToRoute('visitor.expenseForm.bundleMonthly');
    }


}
