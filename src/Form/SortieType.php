<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Translation\t;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure de début',
                'data' => new \DateTime(),
                'html5' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date et heure de fin',
                'data' => new \DateTime(),
                'html5' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => 'Nombre max. de participant',
                'attr' => ['class' => 'form-control']
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Informations sur la sortie',
                'attr' => ['class' => 'form-control']
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'libelle',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('e')->orderBy('e.libelle', 'ASC');
                },
                'attr' => ['class' => 'form-control']
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                },
                'attr' => ['class' => 'form-control']
            ])
            /* @helps-a-lot https://grafikart.fr/tutoriels/champs-imbriques-888  */
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez une ville',
                'mapped' => false,
//                'choice_label' => 'nom',
//                'query_builder' => function (EntityRepository $repository) {
//                    return $repository->createQueryBuilder('v')->orderBy('v.nom', 'ASC');
//                },
                'required' => false
            ])
            ->add('lieu', EntityType::class, [
            'class' => Lieu::class,
            'choices' => [],
            'mapped' => true,
        ]);
        /*$builder->get('ville')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->addLieuxField($form->getParent(), $form->getData());
            }
        );*/
    }

    private function addLieuxField(FormInterface $form, ?Ville $ville)
    {
        $form->add('lieu', EntityType::class, [
            'class' => Lieu::class,
            'placeholder' => $ville ? 'Sélectionnez un lieu' : 'Sélectionnez une ville !',
            'choices' => $ville ? $ville->getLieux() : []
        ]);
        /*
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'lieu',
            EntityType::class,
            null,
            [
                'class' => 'App\Entity\Lieu',
                'placeholder' => 'Sélectionnez le lieu',
                'required' => true,
                'mapped' => true,
                'auto_initialize' => false,
                'choices' => $ville->getLieux()
            ]
        );
        $form->add($builder->getForm());
        */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
