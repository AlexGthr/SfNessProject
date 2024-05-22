<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', TextType::class, [
                'label' => 'Nom du produit :*',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('stock', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('categoriser', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
                'required' => false,
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('picture', EntityType::class, [
                'class' => Picture::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'buttonSubmit'
                ] 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
