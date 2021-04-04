<?php

namespace App\Validator;

use DateTime;
use App\Entity\LineExpenseOutBundle;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DayOfDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof DayOfDate) {
            throw new UnexpectedTypeException($constraint, DayOfDate::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof DateTime) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'DateTime');
        }

        $dateVerif = new DateTime(); // crée une date pour faire la vérification de la date

        if ($value->format('Y-m') != $dateVerif->format('Y-m')) {
            // compare si le mois et la date du formulaire sont conforme à ceux d'aujourd'hui
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ DateTime }}', $value->format('Y-m-d'))
                ->addViolation();
        } 
    }





    public function validationDatelineExpenseOutBundleForm(LineExpenseOutBundle $entity): bool
    {
        $dateVerif = new DateTime(); // crée une date pour faire la vérification de la date du formulaire
            
        return $entity->getDate()->format('Y-m') != $dateVerif->format('Y-m'); // compare si le mois et la date du formulaire sont conforme à ceux d'aujourd'hui  
    }
}