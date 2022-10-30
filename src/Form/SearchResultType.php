<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Competition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoryName', EntityType::class, [
                'label' => 'Categorie',
                'class' => Category::class,
                'choice_label' => 'category_name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('competitionYear', EntityType::class, [
                'label' => 'Année',
                'class' => Competition::class,
                'choice_label' => 'competition_year',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('sumbit', SubmitType::class, [
                'label' => 'Afficher',
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
