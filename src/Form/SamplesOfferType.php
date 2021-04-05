<?php

namespace App\Form;

use App\Entity\Medication;
use App\Entity\SamplesOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;

class SamplesOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('medication', EntityType::class, [
                'class' => Medication::class,
                'choice_label' => 'name',
            ])
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new Positive([
                        'message' => "Le montant doit être strictement supérieur à 0."
                    ]),
                    new NotBlank([
                        'message' => "Vous devez renseigner la quantité d'échantillon offert."
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SamplesOffer::class,
        ]);
    }
}
