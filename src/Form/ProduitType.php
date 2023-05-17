<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Stock;
use App\Form\StockType;
use App\Entity\Fournisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix', MoneyType::class, [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label' => 'Prix ',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
            ])
            ->add('categorie_id', EntityType::class, [
                'class' => Categorie::class,
                'label' => 'Catégorie'
            ])
            ->add('ordonnance', CheckboxType::class, [
                'label' => 'Ordonnance',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image du produit',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false
            ])

//            ceci fait référence au formulaire Stock pour reprendre les champs qu'y existe. C'est aussi la propriété récupérer dans la vu : form.Stock.quantite
            ->add('Stock', StockType::class, [
                'required' => true,
                'mapped' => false,
                'property_path' => 'stock.quantite',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
