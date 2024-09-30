<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Comment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishDate', DateTimeType::class, [
                'widget' => 'single_text',
                'mapped' => false,
            ])
            ->add('content')
            ->add('advert', EntityType::class, [
                'class' => Advert::class,
                'choice_label' => 'id',
                'mapped' => false,
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'mapped' => false,
            ])
            ->add('answerTo', EntityType::class, [
                'class' => Comment::class,
                'choice_label' => 'id',
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
