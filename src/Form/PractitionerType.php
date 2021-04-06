<?php

namespace App\Form;

use App\Entity\Workplace;
use App\Entity\Practitioner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PractitionerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer un nom."
                    ]),
                ]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer un prénom."
                    ]),
                ]
            ])
            ->add('adress', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez une adresse postale."
                    ])
                ]
            ])
            ->add('postalCode', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez un code postal."
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'minMessage' => "Veuillez un code postal valide.",
                        'maxMessage' => "Veuillez un code postal valide.",
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer une ville.",
                    ]),
                ]
            ])
            ->add('coeffReputation', NumberType::class, [
                'constraints' => [
                    new Positive([
                        'message' => "Le coefficient de réputation doit être strictement supérieur à 0."
                    ]),
                    new NotBlank([
                        'message' => "Vous devez renseigner le coefficient de réputation."
                    ])
                ]
            ])
            ->add('workplace', EntityType::class, [
                'class' => Workplace::class,
                'choice_label' => 'wording',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Practitioner::class,
        ]);
    }
}
