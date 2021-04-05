<?php

namespace App\Controller\accountant;

use App\Entity\ExpenseForm;
use App\Repository\StateRepository;
use App\Entity\LineExpenseOutBundle;
use App\Service\ExpenseFormCreation;
use App\Repository\ExpenseFormRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LineExpenseBundleRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LineExpenseOutBundleRepository;
use App\Service\ExpenseFormUpdate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/accountant')]
/**
 * Class ExpenseFormController
 *
 * Contrôleur pour toutes les pages lié aux fiches frais de la partie comptable
 */
class ExpenseFormController extends AbstractController
{
    private ExpenseFormRepository $expenseFormRepository;
    private StateRepository $stateRepository;
    private ExpenseFormUpdate $expenseFormUpdate;

    public function __construct(ExpenseFormRepository $expenseFormRepository,ExpenseFormCreation $expenseFormCreation,
    LineExpenseBundleRepository $lineExpenseBundleRepository, LineExpenseOutBundleRepository $lineExpenseOutBundleRepository, StateRepository $stateRepository, ExpenseFormUpdate $expenseFormUpdate)
    {
        $this->expenseFormRepository = $expenseFormRepository;
        $this->expenseFormCreation = $expenseFormCreation;
        $this->lineExpenseBundleRepository = $lineExpenseBundleRepository;
        $this->lineExpenseOutBundleRepository = $lineExpenseOutBundleRepository;
        $this->stateRepository = $stateRepository;
        $this->expenseFormUpdate = $expenseFormUpdate;
    }

    #[Route('/expenseForm/listExpenseFormLeft', name: 'accountant.expense_form.list_expense_form_left')]
    // Génère et renvoie la page des fiche frais restant à traiter
    public function listExpenseFormLeft(): Response
    {
        $state_cloture = $this->stateRepository->findBy(['wording' => 'Saisie clôturée']);

        // Sélection de tous les fiches frais restant à valider ou refusé
        $expenseformrepository = $this->expenseFormRepository->findBy(['state' => $state_cloture]);

        // affichage de la vue
        return $this->render('accountant/expenseForm/listExpenseFormLeft.html.twig', [
            'expenseform' => $expenseformrepository
        ]);
    }

    #[Route('expenseForm/listExpenseFormTreated', name: 'accountant.expense_form.list_expense_form_treated')]
    // Génère et renvoie la page des fiche frais traité
    public function listExpenseFormTreated(): Response
    {
        $stateReimbursed = $this->stateRepository->findBy(['wording' => "Remboursée"])[0];
        $stateValidated = $this->stateRepository->findBy(['wording' => "Validée et mise en paiement"])[0];

        // Sélection de tous les fiches frais restant à valider ou refusé
        $expenseformrepository = $this->expenseFormRepository->getExpenseFormTreated($stateReimbursed, $stateValidated);

        // affichage de la vue
        return $this->render('accountant/expenseForm/listExpenseFormTreated.html.twig', [
            'expenseform' => $expenseformrepository
        ]);
    }

    #[Route('expenseForm/consultExpenseForm/{id}', name:"accountant.expense_form.consult_expense_form")]
    // Génère et renvoie la page détail d'un frais forfait en fonction de son id
    public function consultExpenseForm(ExpenseForm $entity): Response
    {
        // Sélection des lignes frais forfait et hors forfait
        $lineExpenseBundleArray = $this->lineExpenseBundleRepository->findLineExpenseBundleByExpenseForm($entity);
        $lineExpenseOutBundleArray = $this->lineExpenseOutBundleRepository->findLineExpenseOutBundleByExpenseForm($entity);
        
        return $this->render('accountant/expenseForm/consultExpenseForm.html.twig', [
            'bundleMonthly' => $entity,
            'lineExpenseBundleArray' => $lineExpenseBundleArray,
            'lineExpenseOutBundleArray' => $lineExpenseOutBundleArray,
        ]);
    }

    #[Route('expenseForm/toggleValid/{id}', name:'accountant.expense_form.toggle_valid')]
    // Génère et renvoie la page détail d'un frais forfait en fonction de son id
    public function toggleValid(int $id = null, LineExpenseOutBundle $entity): Response
    {
        $entity->setValid(!$entity->getValid());

        $this->expenseFormUpdate->updateExpenseFormAmount($entity->getExpenseForm());

        $this->getDoctrine()->getManager()->flush($entity);

        $this->addFlash('noticeExpenseForm',  $id ? "Le frais hors forfait a bien été accepté" : "Le frais hors forfait a bien été refusé");

        return $this->redirectToRoute('accountant.expense_form.consult_expense_form', ['id' => $entity->getExpenseForm()->getId()]);
    }

    #[Route('expenseForm/formTreatment/{id}', name:'accountant.expense_form.form_treatment')]
    // Mets à jour la prise en compte des frais rembourser, et redirige sur la même page
    public function formTreatment(ExpenseForm $entity): Response
    {

        $entity->setState($this->stateRepository->findBy(['wording' => 'Validée et mise en paiement'])[0]);

        $this->getDoctrine()->getManager()->flush($entity);

        return $this->redirectToRoute('accountant.expense_form.list_expense_form_left');
    }
}
