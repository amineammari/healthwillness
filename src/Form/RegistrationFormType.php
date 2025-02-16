<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom', // Add a label for better UX
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre nom.']),
                ],
                'attr' => ['class' => 'form-control'], // Add Bootstrap class
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom', // Add a label for better UX
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre prénom.']),
                ],
                'attr' => ['class' => 'form-control'], // Add Bootstrap class
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email', // Add a label for better UX
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre email.']),
                    new Email(['message' => 'Veuillez entrer un email valide.']),
                ],
                'attr' => ['class' => 'form-control'], // Add Bootstrap class
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'form-control password-field']], // Add Bootstrap class
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un mot de passe.']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                        'max' => 4096, // Maximum length allowed by Symfony for security reasons
                    ]),
                ],
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de Naissance', // Add a label for better UX
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control'], // Add Bootstrap class
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo', // Add a label for better UX
                'mapped' => false, // This field is not mapped to the entity
                'required' => false,
                'attr' => ['class' => 'form-control'], // Add Bootstrap class
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Rôle', // Add a label for better UX
                'choices' => [
                    'Médecin' => 'medecin',
                    'Patient' => 'patient',
                    'Administrateur' => 'admin',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'form-select'], // Add Bootstrap class
            ])
            ->add('register', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary mt-3', // Add Bootstrap class and margin
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true, // Enable CSRF protection
            'csrf_field_name' => '_token', // Customize CSRF token field name
            'csrf_token_id'   => 'registration_form', // Customize CSRF token ID
        ]);
    }
}