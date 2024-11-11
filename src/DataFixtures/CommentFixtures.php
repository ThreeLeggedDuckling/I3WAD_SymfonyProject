<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 40; $i++) {
            $comment = new Comment();
            $comment->setAdvert($this->getReference('advert' . rand(0,39)));
            $comment->setPublishDate(new \DateTime());
            $comment->setAuthor($this->getReference('user' . rand(0,29)));
            $comment->setContent($faker->sentence());

            $this->addReference("comment{$i}", $comment);
            $manager->persist($comment);
        }

        for ($i = 0; $i <25; $i++) {
            $comment = new Comment();
            $comment->setAnswerTo($this->getReference('comment' . rand(0, 39)));
            $comment->setAdvert($comment->getAnswerTo()->getAdvert());
            $comment->setPublishDate(new \DateTime());
            $comment->setAuthor($this->getReference('user' . rand(0,29)));
            $comment->setContent($faker->sentence(rand(4, 15)));

            // $this->addReference("answer{$i}", $comment);
            $manager->persist($comment);
        }

        // LAISSE TOMBER
        // for ($i = 0; $i <10; $i++) {
        //     $comment = new Comment();
        //     $comment->setAnswerTo($this->getReference('answer' . rand(0, 14)));
        //     $comment->setAdvert($comment->getAnswerTo()->getAdvert());
        //     $comment->setPublishDate(new \DateTime());
        //     $comment->setAuthor($this->getReference('user' . rand(0,19)));
        //     $comment->setContent($faker->sentence());

        //     // $this->addReference("answer{$i}", $comment);
        //     $manager->persist($comment);
        // }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [AdvertFixtures::class];
    }
}
