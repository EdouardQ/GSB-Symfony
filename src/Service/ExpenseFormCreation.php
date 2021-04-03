<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\ExpenseForm;
use App\Repository\StateRepository;

class ExpenseFormCreation
{
    private StateRepository $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function creation(User $user,string $month):ExpenseForm
    {
        // Récupération de l'état de fiche de frais "Fiche créée, saisie en cours" et extraction de la requete dans uen variable
        $stateOnCreation = $this->stateRepository->findBy([
            'libelle' => "Fiche créée, saisie en cours",
        ])[0]; // [0] car l'objet est dans un tableau

        $entity = new ExpenseForm;
        $entity->setUser($user);
        $entity->setMois($month);
        $entity->setNbJustificatifs(0);
        $entity->setMontantValide(0);
        $entity->setDateModif(new DateTime(date("H:i:s d-m-Y")));
        $entity->setState($stateOnCreation);
        $entity->setToken($user->getLogin().'_'.$month);

        return $entity;
    }
}