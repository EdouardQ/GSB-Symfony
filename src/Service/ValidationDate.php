<?php

namespace App\Service;

use App\Entity\LineExpenseOutBundle;
use DateTime;

class ValidationDate
{
    public function validationDatelineExpenseOutBundleForm(LineExpenseOutBundle $entity): bool
    {
        $dateVerif = new DateTime(); // crée une date pour faire la vérification de la date du formulaire
            
        return $entity->getDate()->format('Y-m') != $dateVerif->format('Y-m'); // compare si le mois et la date du formulaire sont conforme à ceux d'aujourd'hui  
    }
}