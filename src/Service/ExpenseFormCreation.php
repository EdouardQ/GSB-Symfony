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

    public function creation(User $user,string $month): ExpenseForm
    {
        // Récupération de l'état de fiche de frais "Fiche créée, saisie en cours" et extraction de la requete dans uen variable
        $stateOnCreation = $this->stateRepository->findBy([
            'wording' => "Fiche créée, saisie en cours",
        ])[0]; // [0] car l'objet est dans un tableau

        $entity = new ExpenseForm;
        $entity->setUser($user);
        $entity->setMonth($month);
        $entity->setNbSupportingDocuments(0);
        $entity->setValidAmount(0);
        $entity->setDateUpdate(new DateTime(date("H:i:s d-m-Y")));
        $entity->setState($stateOnCreation);
        $entity->setToken($user->getLogin().'_'.$month);

        return $entity;
    }
}