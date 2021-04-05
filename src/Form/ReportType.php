<?php

namespace App\Form;

use App\Entity\Practitioner;
use App\Entity\Report;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'empty_data' => null,
                'invalid_message' => 'Veuillez renseigner la date.',
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer une date.",
                    ]),
                ],
            ])
            ->add('reasonVisit', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer le motif de la visite.",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => "Veuillez rentrer le motif de la visite.",
                    ]),
                ],
            ])
            ->add('summary', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer le bilan de la visite.",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => "Veuillez rentrer le bilan de la visite.",
                    ]),
                ],
            ])
            ->add('practitioner', EntityType::class, [
                'class' => Practitioner::class,
                'choice_label' => function (Practitioner $practitioner) {
                    return $practitioner->getFullName();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
    }
}
