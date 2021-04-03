<?php

namespace App\Form;

use App\Entity\ExpenseBundle;
use App\Entity\LineExpenseBundle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;


class LineExpenseBundleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite', IntegerType::class, [
                'constraints' => [
                    new Positive([
                        'message' => "La quantité doit être strictement supérieure à 0."
                    ]),
                ]
            ])
            ->add('expenseBundle', EntityType::class, [
                'class' => ExpenseBundle::class,
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineExpenseBundle::class,
        ]);
    }
}
