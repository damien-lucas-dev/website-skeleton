<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\PropertySearch;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', SearchType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Mot-clé'
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'label' => 'Lieu',
                'required' => false,
                'mapped' => false
            ])
            /*->add('start', DateType::class, [
                'input' => 'string',
                'input_format' => 'd/m/Y',
                'label' => 'Après le',
                'required' => false,
                'mapped' => false
            ])*/
            ->add('owner', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur',
                'required' => false,
                'empty_data' => null,
                'mapped' => false
            ])
            ->add('subscribed',CheckboxType::class,  [
                'label' => 'Sorties auxquelles je suis inscrit',
                'required' => false,
                'mapped' => false
            ])
            ->add('passed',CheckboxType::class,  [
                'label' => 'Sorties passées',
                'required' => false,
                'empty_data' => null,
                'mapped' => false
            ])
            ->add('cancelled', CheckboxType::class, [
                'label' => 'Sorties annulées',
                'required' => false,
                'empty_data' => null,
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
        ]);
    }
}
