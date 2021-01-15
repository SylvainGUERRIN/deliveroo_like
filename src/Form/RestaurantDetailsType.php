<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' =>'Le nom de votre restaurant',
                'attr' => ['placeholder' => 'Veuillez mettre Le nom de votre restaurant']
            ])
            ->add('number', NumberType::class, [
                'required' => true,
                'label' =>'Le numéro de téléphone de votre restaurant',
                'attr' => ['placeholder' => 'Veuillez mettre Le numéro de téléphone de votre restaurant']
            ])
            ->add('opensAt', TimeType::class, [
                'label' =>'Heure d\'ouverture',
            ])
            ->add('closesAt', TimeType::class, [
                'label' =>'Heure de fermeture',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' =>'choisissez le type de votre cuisine',
            ])
            ->add('siren', TextType::class, [
                'required' => true,
                'label' =>'Le numéro siren de votre restaurant',
                'attr' => ['placeholder' => 'Veuillez mettre Le siren de votre restaurant']
            ])
            ->add('delivery', ChoiceType::class, [
                'required' => true,
                'label' => 'Proposez-vous de la livraison ?',
                'choices' => [
                    'non, pas encore' => 'non',
                    'oui, avec un partenaire' => 'oui, avec un partenaire',
                    'oui, avec mes livreurs' => 'oui, avec mes livreurs'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(["data_class" => Restaurant::class]);
    }

}
