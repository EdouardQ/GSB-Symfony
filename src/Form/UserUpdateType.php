<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "L'utilisateur doit avoir un login d'au moins 3 caractères."
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => "L'utilisateur doit avoir un login d'au moins 3 caractères."
                    ])
                ]
            ])
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
            ->add('hiringDate', DateType::class, [
                'widget' => 'single_text',
                'empty_data' => null,
                'invalid_message' => 'Veuillez renseigner la date.',
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer une date.",
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer une adresse email.",
                    ]),
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer une ville.",
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
