<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tailleCommandes', CollectionType::class, [
                'entry_type' => TailleCommandeType::class,
                'entry_options' => ['label' => false], // cette ligne pour annuler tout label en haut venant de taille_commande
                'allow_add' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('TVA', ChoiceType::class, [
                'choices' => [
                    '0%' => 0,
                    '10%' => 10,
                ],
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
