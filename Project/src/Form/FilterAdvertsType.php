<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Tag;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('orderby')
            ->add('after', DateType::class)
            ->add('before', DateType::class)
            ->add('game', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => ''
            ])
            ->add('genre')
            ->add('level')
            ->add('modality')
            
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
