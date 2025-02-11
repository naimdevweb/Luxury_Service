<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            

        ->add('email', EmailType::class, [
            'required' => false,
            'mapped' => false,
            'label' => 'Email',
            'attr' => [
                'id' => 'email',
                'class' => 'form-control',
            ],
        ])
        ->add('newPassword', RepeatedType::class, [
            'mapped' => false,
            'required' => false,
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'New Password',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'password',
                ],
            ],
            'second_options' => [
                'label' => 'Confirm New Password',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'password_repeat',
                ],
            ],
            'invalid_message' => 'The password fields must match.',
            'constraints' => [
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    'max' => 4096,
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}