<?php

namespace App\Form;

use App\Entity\Tag;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FilterAdvertsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            // date publication
            ->add('after', DateType::class, [
                'label' => 'After ',
                'required' => false,
            ])
            ->add('before', DateType::class, [
                'label' => 'Before ',
                'required' => false,
            ])

            //jeu
            ->add('game', EntityType::class, [
                'label' => 'Game ',
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
                'label' => 'Genre ',
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
                'label' => 'Level ',
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
                'label' => 'Modality ',
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
            'csrf_protection' => false,
        ]);
    }
}
