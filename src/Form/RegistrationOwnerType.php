<?php


namespace App\Form;


use App\Entity\Address;
use App\Entity\City;
use App\Entity\Restaurant;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationOwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
//            ->add('name')
//        ;

//        $builder->add('address', CollectionType::class, [
//            'entry_type' => RestaurantAddressType::class,
//            'entry_options' => ['label' => false]
//        ]);

//        $builder
//            ->add('number')
////            ->add('siren') add on entity
////        ->add('delivery') add on entity (a select "proposez-vous de la livraison?" in form choicies non, pas encore
////        oui, avec un partenaire   oui, avec mes livreurs
//        //add field type de cuisine avec les catégories de cuisines en select
//        ;

        $builder
            ->add('profile', RegistrationType::class, [
                'data_class' => User::class,
                'label' => false
            ])
        ;

        $builder
            ->add('restaurant', RestaurantType::class, [
                'data_class' => Restaurant::class,
                'label' => 'Votre restaurant'
            ])
        ;

        $builder
            ->add('name', TextType::class, [
                'data_class' => Address::class,
                'required' => true,
                'label' =>'Votre rue',
                'attr' => ['placeholder' => 'Veuillez mettre votre rue']
            ])
            ->add('city', TextType::class, [
                'data_class' => City::class,
                'required' => true,
                'label' =>'Renseignez votre ville',
                'attr' => ['placeholder' => 'Veuillez mettre votre ville']
            ])
            ->add('line1', TextType::class, [
                'data_class' => Address::class,
                'required' => true,
                'label' =>'Votre code postal',
                'attr' => ['placeholder' => 'Veuillez mettre votre prénom']
            ])
            ->add('line2', TextType::class, [
                'data_class' => Address::class,
                'required' => false,
                'label' =>'Adresse complémentaire',
                'attr' => ['placeholder' => 'Si besoin, vous pouvez compléter votre adresse']
            ])
        ;

//        $builder->add('user', CollectionType::class, [
//            'entry_type' => RegistrationType::class,
//            'entry_options' => ['label' => false]
//        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
//            'data_class' => Restaurant::class
        ]);
    }

}
