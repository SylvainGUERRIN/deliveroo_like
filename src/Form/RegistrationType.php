<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' =>'Votre prénom',
                'attr' => ['placeholder' => 'Veuillez mettre votre prénom']
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' =>'Votre nom',
                'attr' => ['placeholder' => 'Veuillez mettre votre nom']
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' =>'Votre email',
                'attr' => ['placeholder' => 'Veuillez mettre votre email']
            ])
            ->add('password', RepeatedType::class, [
                'label' =>'Votre mot de passe',
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => false, 'attr' => ['placeholder' => 'Mot de passe']],
                'second_options' => ['label' => false, 'attr' => [
                    'placeholder' => 'Confirmez le mot de passe']],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
