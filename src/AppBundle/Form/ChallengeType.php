<?php

namespace AppBundle\Form;

use AppBundle\Entity\Challenge;
use AppBundle\Validator\Constraints\NotEmptyArrayCollection;
use AppBundle\Validator\Constraints\UniqueQuestionAnswers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChallengeType extends AbstractType
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
            ->add('correctAnswer', AnswerType::class, [
                'description' => 'Correct answer',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('image', ImageType::class, [
                'description' => 'Image',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('status', ChoiceType::class, [
                'description' => 'Status',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    Challenge::STATUS_ENABLED,
                    Challenge::STATUS_DISABLED
                ],
                'constraints' => [
                    new NotBlank()
                ]
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
