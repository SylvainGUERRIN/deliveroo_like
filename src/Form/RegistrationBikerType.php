<?php

namespace App\Form;

use App\Entity\Biker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationBikerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('enterpriseCode')
            ->add('rightToCreateEnterprise')
            ->add('birthdayDate')
            ->add('sponsorship')
            ->add('iban')
            ->add('transportation')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Biker::class,
        ]);
    }

}
