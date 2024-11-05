<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('area')
            ->add('content')
            // jeu
            ->add('game', EntityType::class, [
                'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'game')
                    ->orderBy('t.name', 'asc');
                },
                'choice_label' => 'name',
                'required' => false,
            ])
            // genre
            ->add('genre', EntityType::class, [
                'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'genre')
                    ->orderBy('t.name', 'asc');
                },
                'choice_label' => 'name',
                'required' => false,
            ])
            // niveau
            ->add('level', EntityType::class, [
                'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'level');
                },
                'choice_label' => 'name',
                'expanded' => true,
            ])
            //modalité
            ->add('modality', EntityType::class, [
                'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'modality')
                    ->orderBy('t.name', 'asc');
                },
                'choice_label' => 'name',
                'expanded' => true,
            ])
            // région ?
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
