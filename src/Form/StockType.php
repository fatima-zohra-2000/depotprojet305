<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Produit;
use App\Entity\Fournisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', IntegerType::class)
            ->add('fournisseur_id', EntityType::class, [
                'label' => 'Fournisseur',
                'class' => Fournisseur::class, //Pour marquer que c'est un objet Fournisseur et récupérer son id
                'choice_label' => 'nom'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
