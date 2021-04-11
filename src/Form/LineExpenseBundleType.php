<?php

namespace App\Form;

use App\Entity\ExpenseBundle;
use App\Entity\LineExpenseBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class LineExpenseBundleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new Positive([
                        'message' => "La quantité doit être strictement supérieure à 0."
                    ]),
                    new NotBlank([
                        'message' => "La quantité doit être strictement supérieure à 0.",
                    ]),
                ]
            ])
            ->add('expenseBundle', EntityType::class, [
                'class' => ExpenseBundle::class,
                'choice_label' => 'wording',
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
