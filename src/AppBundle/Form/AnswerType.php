<?php

namespace AppBundle\Form;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Challenge;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'description' => 'Text content',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('challenge', EntityType::class, [
                'description' => 'Calculator',
                'label' => 'calculation.calculator',
                'class' => Challenge::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('deviceBrand', TextType::class, [
                'description' => 'Device brand',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('deviceModel', TextType::class, [
                'description' => 'Device model',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('deviceOS', TextType::class, [
                'description' => 'Device operating system',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('deviceOSVersion', TextType::class, [
                'description' => 'Device operating system version',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('timeResult', TextType::class, [
                'description' => 'Time result',
                'constraints' => [
                    new NotBlank(),
                    new Range([
                        'min' => 0
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Answer::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
