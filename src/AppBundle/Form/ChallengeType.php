<?php

namespace AppBundle\Form;

use AppBundle\Entity\Challenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChallengeType extends AbstractType
{
    const VALIDATION_CREATE = 'create';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'description' => 'Challenge name',
                'label' => 'challenge.name',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('correctAnswer', TextType::class, [
                'description' => 'Correct answer',
                'label' => 'challenge.correctAnswer',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('description', TextType::class, [
                'description' => 'Challenge description',
                'label' => 'challenge.description',
                'required' => false
            ])
            ->add('image', ImageType::class, [
                'description' => 'Image',
                'label' => 'challenge.image',
                'constraints' => [
                    new NotBlank([
                        'groups' => [ChallengeType::VALIDATION_CREATE]
                    ])
                ],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Challenge::class
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
