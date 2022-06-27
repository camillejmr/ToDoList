<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre nom.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit comporter au minimum {{ limit }} caractères.',
                        'max' => 55,
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Mreci de saisir votre prénom.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit comporter au minimum {{ limit }} caractères.',
                        'max' => 55,
                    ]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre adresse.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Your adress should be at least {{ limit }} characters',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('codePostal', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir le code postal.',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le code postal doit comporter {{ limit }} caractères.',
                        'max' => 5,
                    ]),
                ],
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir la ville.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'La ville doit comporter au minimum {{ limit }} caractères.',
                        'max' => 80,
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe',],
                'second_options' => ['label' => 'Vérification du mot de passe'],
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au minimum {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
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
