<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Advert;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            // orderby
            ->add('orderby', ChoiceType::class, [
                'choices' => [
                    'date (newest)' => 'newest',
                    'date (oldest)' => 'oldest',
                    'popularity' => 'popularity',
                ]
            ])
            // date publication
            ->add('after', DateType::class, [
                'required' => false,
            ])
            ->add('before', DateType::class, [
                'required' => false,
            ])
            //jeu
            ->add('game', EntityType::class, [
                // 'mapped' => false,
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
                // 'mapped' => false,
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
                // 'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'level');
                },
                'choice_label' => 'name',
                'required' => false,
            ])
            // modalité
            ->add('modality', EntityType::class, [
                // 'mapped' => false,
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) :QueryBuilder {
                    return $er->createQueryBuilder('t')
                    ->andWhere('t.type = :type')
                    ->setParameter('type', 'modality')
                    ->orderBy('t.name', 'asc');
                },
                'choice_label' => 'name',
                'required' => false,
            ])
            // champ région pour irl ?
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
