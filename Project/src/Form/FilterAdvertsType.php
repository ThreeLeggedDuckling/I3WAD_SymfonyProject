<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Tag;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterAdvertsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         *  FILTERS :
         *    - order by
         *    - published before
         *    - published after
         *    - tags
         *        - game
         *        - genre
         *        - level
         *        - modality
         */

        $builder
            ->add('orderby', ChoiceType::class, [
                'choices' => [
                    'date (newest)' => 'newest',
                    'date (oldest)' => 'oldest',
                    'popularity' => 'popularity',
                ]
            ])
            ->add('after', DateType::class, [
                'required' => false,
            ])
            ->add('before', DateType::class, [
                'required' => false,
            ])

            // changer type champs
            ->add('game', EntityType::class, [
                'mapped' => false,
                'required' => false,
                'class' => Tag::class,
                'choice_label' => 'name',
            ])
            ->add('genre', EntityType::class, [
                'mapped' => false,
                'required' => false,
                'class' => Tag::class,
                'choice_label' => 'name',
            ])

            // ->add('game', EntityType::class, [
            //     'mapped' => false,
            //     'class' => Tag::class,
            //     'query_builder' => function (EntityRepository $er) :QueryBuilder {
            //         return $er->createQueryBuilder('t')
            //         ->andWhere('t.type = :type')
            //         ->setParameter('type', 'game');
            //     },
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            // ->add('genre', EntityType::class, [
            //     'mapped' => false,
            //     'class' => Tag::class,
            //     'query_builder' => function (EntityRepository $er) :QueryBuilder {
            //         return $er->createQueryBuilder('t')
            //         ->andWhere('t.type = :type')
            //         ->setParameter('type', 'genre');
            //     },
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            // ->add('level', EntityType::class, [
            //     'mapped' => false,
            //     'class' => Tag::class,
            //     'query_builder' => function (EntityRepository $er) :QueryBuilder {
            //         return $er->createQueryBuilder('t')
            //         ->andWhere('t.type = :type')
            //         ->setParameter('type', 'level');
            //     },
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            // ->add('modality', EntityType::class, [
            //     'mapped' => false,
            //     'class' => Tag::class,
            //     'query_builder' => function (EntityRepository $er) :QueryBuilder {
            //         return $er->createQueryBuilder('t')
            //         ->andWhere('t.type = :type')
            //         ->setParameter('type', 'modality');
            //     },
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            
            // ->add('publishDate', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('isOpen')
            // ->add('area')
            // ->add('content')
            // ->add('author', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('tags', EntityType::class, [
            //     'class' => Tag::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
