<?php

namespace App\Form;

use App\Entity\LineExpenseOutBundle;
use App\Validator\DayOfDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LineExpenseOutBundleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wording', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer un libelle.",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => "Veuillez rentrer un libelle.",
                    ]),
                ],
            ])
            ->add('date', DateType::class, [
            'widget' => 'single_text',
            'empty_data' => null,
            'constraints' => [
                new NotBlank([
                    'message' => "Veuillez rentrer une date.",
                ]),
                new DayOfDate(),
            ],
        ])
            ->add('amount', IntegerType::class, [
                'constraints' => [
                    new Positive([
                        'message' => "Le montant doit être strictement supérieur à 0."
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineExpenseOutBundle::class,
        ]);
    }
}
