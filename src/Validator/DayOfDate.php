<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class DayOfDate extends Constraint
{
    public $message = "La date rentrée n'est pas valide.";
}