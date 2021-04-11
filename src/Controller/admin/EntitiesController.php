<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Entity\Medication;
use App\Entity\Practitioner;
use App\Form\MedicationType;
use App\Form\UserCreateType;
use App\Form\UserUpdateType;
use App\Form\PractitionerType;
use App\Form\SwitchPasswordType;
use App\Repository\MedicationRepository;
use App\Repository\PractitionerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/admin')]

class EntitiesController extends AbstractController
{
    private PractitionerRepository $practitionerRepository;
    private MedicationRepository $medicationRepository;

    public function __construct(PractitionerRepository $practitionerRepository, MedicationRepository $medicationRepository)
    {
        $this->practitionerRepository = $practitionerRepository;
        $this->medicationRepository = $medicationRepository;
    }


    #[Route('/update/user/{id}', name: 'admin.update.user')]

    public function updateUser(User $user, Request $request): Response
    {
        $form = $this->createForm(UserUpdateType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            if($user->getRoles() === ["ROLE_ACCOUNTANT"]){
                $this->addFlash('noticeAccountant', "Le comptable a bien été enregistré");

                return $this->redirectToRoute('admin.homepage.list_accountants');
            }

            $this->addFlash('noticeVisitor', "Le visiteur a bien été modifié");

            return $this->redirectToRoute('admin.homepage.list_visitors');
        }

        return $this->render('admin/entities/userUpdateForm.html.twig',[
            'form' => $form->createView(),
            'userEntity' => $user,
        ]);
    }

    #[Route('/create/user/{role}', name: 'admin.create.user')]

    public function createUser(string $role, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {   
        $user = new User;

        $form = $this->createForm(UserCreateType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // encode the plain password
             $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setEnabled(False);

            if($role === "visitor"){
                $user->setRoles(["ROLE_VISITOR"]);
            }
            elseif($role === "accountant"){
                $user->setRoles(["ROLE_ACCOUNTANT"]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($user);
            $entityManager->flush();

            if($role === "accountant"){
                $this->addFlash('noticeAccountant', "Le comptable a bien été modifié");

                return $this->redirectToRoute('admin.homepage.list_accountants');
            }

            $this->addFlash('noticeVisitor', "Le visiteur a bien été modifié");

            return $this->redirectToRoute('admin.homepage.list_visitors');
        }

        return $this->render('admin/entities/userCreateForm.html.twig',[
            'form' => $form->createView(),
        ]);
    }


    #[Route('/toggle/user/{id}', name: 'admin.toggle.user')]

    public function toggleUser(User $user): Response
    {
        $user->setEnabled(!$user->getEnabled());

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->flush();

        if($user->getRoles() === ["ROLE_ACCOUNTANT"]){
            $this->addFlash('noticeAccountant', "Le comptable a bien été enregistré");

            return $this->redirectToRoute('admin.homepage.list_accountants');
        }

        $this->addFlash('noticeVisitor', "Le visiteur a bien été modifié");

        return $this->redirectToRoute('admin.homepage.list_visitors');
    }

    #[Route('/password/{id}', name: 'admin.password')]

    public function switchPassword(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(SwitchPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('noticeVisitor', "Le visiteur a bien été modifié");

            return $this->redirectToRoute('admin.homepage.list_visitors');
        }

        return $this->render('admin/entities/switchPassword.html.twig',[
            'form' => $form->createView(),
            'userEntity' => $user,
        ]);
    }

    #[Route('/practitionerForm/{id}', name: 'admin.practitionerForm')]

    public function practitionerForm(int $id = null, Request $request): Response
    {
        $entity = $id ? $this->practitionerRepository->find($id) : new Practitioner;

        $form = $this->createForm(PractitionerType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('noticePratitioner', $id? "Le praticien a bien été modifié" : "Le Praticien a bien été crée");

            return $this->redirectToRoute('admin.homepage.list_practitioners');
        }


        return $this->render('admin/entities/practitionerForm.html.twig', [
            'form' => $form->createView(),
            'entity' => $entity,
        ]);
    }

    #[Route('/medicationForm/{id}', name: 'admin.medicationForm')]

    public function medicationForm(int $id = null, Request $request): Response
    {
        $entity = $id ? $this->medicationRepository->find($id) : new Medication;

        $form = $this->createForm(MedicationType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('noticeMedication', $id? "Le médicament a bien été modifié" : "Le médicament a bien été crée");

            return $this->redirectToRoute('admin.homepage.list_medications');
        }


        return $this->render('admin/entities/medicationForm.html.twig', [
            'form' => $form->createView(),
            'entity' => $entity,
        ]);
    }
    
   
}