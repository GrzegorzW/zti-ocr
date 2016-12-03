<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    private $user;

    public function __construct(TokenStorage $tokenStorage)
    {
        $token = $tokenStorage->getToken();
        if ($token instanceof TokenInterface) {
            $this->user = $token->getUser();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);

        $builder
            ->add('email', EmailType::class, [
                'description' => 'Email',
                'label' => 'user.email',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email([
                        'strict' => true
                    ])
                ]
            ]);

        if ($this->hasRole('ROLE_ADMIN')) {
            $builder->add('enabled', ChoiceType::class, [
                'label' => 'user.enabled',
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'yes' => 1,
                    'no' => 0,
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ]);
        }
    }

    public function hasRole($role)
    {
        return $this->user instanceof User && $this->user->hasRole($role);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => User::class
        ]);
    }

    public function onPreSetData(FormEvent $event)
    {
        $user = $event->getData();

        if ($user instanceof User) {
            $form = $event->getForm();

            if ($user->getId() === null) {
                $form->add('plainPassword', PasswordType::class, [
                    'description' => 'Password',
                    'label' => 'user.password',
                    'constraints' => [
                        new Assert\NotBlank()
                    ]
                ]);
            }
        }
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
