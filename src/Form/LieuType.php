<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('rue', null, [
                'label' => 'Adresse (numéro et rue)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('latitude', NumberType::class, [
                'scale' => 6,
                'attr' => ['class' => 'form-control']
            ])
            ->add('longitude', NumberType::class, [
                'scale' => 6,
                'attr' => ['class' => 'form-control']
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('v')->orderBy('v.nom', 'ASC');
                },
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
