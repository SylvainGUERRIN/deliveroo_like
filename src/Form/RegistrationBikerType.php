<?php

namespace App\Form;

use App\Entity\Biker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('rightToCreateEnterprise', CheckboxType::class,[
                'label'    => 'Avez-vous le droit de créer une entreprise ?',
                'required' => true,
            ])
            ->add('birthdayDate', DateType::class, [
                'widget' => 'single_text'
            ])
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
