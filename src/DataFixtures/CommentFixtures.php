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
            $comment->setPublishDate($faker->dateTimeBetween($comment->getAdvert()->getPublishDate()));
            $comment->setAuthor($this->getReference('user' . rand(0,29)));
            $comment->setContent($faker->sentence());

            $this->addReference("comment{$i}", $comment);
            $manager->persist($comment);
        }

        for ($i = 0; $i <25; $i++) {
            $ref = $this->getReference('comment' . rand(0, 39));

            $comment = new Comment();
            $comment->setAnswerTo($ref);
            $comment->setAdvert($ref->getAdvert());
            $comment->setPublishDate($faker->dateTimeBetween($ref->getPublishDate()));
            $comment->setAuthor($this->getReference('user' . rand(0,29)));
            $comment->setContent($faker->sentence(rand(4, 15)));

            $this->addReference("answer{$i}", $comment);
            $manager->persist($comment);
        }

        for ($i = 0; $i <10; $i++) {
            $ref = $this->getReference('answer' . rand(0, 24));

            $comment = new Comment();
            $comment->setAnswerTo($ref->getAnswerTo());
            $comment->setAdvert($ref->getAdvert());
            $comment->setPublishDate($faker->dateTimeBetween($ref->getPublishDate()));
            $comment->setAuthor($this->getReference('user' . rand(0,19)));
            $comment->setContent('@' . $ref->getAuthor()->getUsername() . ' ' . $faker->sentence());

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [AdvertFixtures::class];
    }
}
