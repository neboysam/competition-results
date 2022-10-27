<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Competitor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CompetitorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom du participant',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisir le prénom du participant'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom du participant',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisir le nom du participant'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du participant',
                'required' => true,
                'attr' => [
                    'placeholder' => "Saisir l'email du participant"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville participant',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisir la ville du participant'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'category_name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('sumbit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competitor::class,
        ]);
    }
}
