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

            // ->add('publishDate', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('isOpen')
            // ->add('author', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('tags', CollectionType::class, [
            //     'entry_type' => EntityType::class,
            //     'entry_options' => [
            //         'class' => Tag::class,
            //         'choice_label' => 'name',
            //         'multiple' => true,
            //     ]
            // ])

            // MODIFIER AVEC CHAMPS RECHERCHE
            ->add('game', EntityType::class, [
                'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'game');
                },
                'choice_label' => 'name',
            ])
            ->add('genre', EntityType::class, [
                'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'genre');
                },
                'choice_label' => 'name',
                'multiple' => true,
            ])
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
            ->add('modality', EntityType::class, [
                'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'modality');
                },
                'choice_label' => 'name',
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
