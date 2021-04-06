<?php

namespace App\Form;

use App\Entity\Medication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MedicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer le code d'identification du médicament",
                    ])
                ]
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer le nom du médicament",
                    ])
                ]
            ])
            ->add('family', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer la famille du médicament",
                    ])
                ]
            ])
            ->add('composition', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer la composition du médicament",
                    ])
                ]
            ])
            ->add('sideEffects', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer les effets secondaires du médicament",
                    ])
                ]
            ])
            ->add('contraindications', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer les contre indications du médicament",
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medication::class,
        ]);
    }
}
