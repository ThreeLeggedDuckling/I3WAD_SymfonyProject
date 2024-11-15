<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Message;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        // messages privés
        for ($i = 0; $i < 20; $i++) {
            $message = new Message();
            $message->setAuthor($this->getReference('user' . rand(0,29)));
            $message->setToGroup(false);
            do {
                $target = $this->getReference('user' . rand(0,29));
            } while ($target == $message->getAuthor());
            $message->setTarget($target);
            $message->setContent($faker->sentence());
            $manager->persist($message);
        }

        // conversation de groupe
        for ($i = 0; $i < 10; $i++) {
            $group = $this->getReference('group' . rand(0,6));
            $author = $faker->randomElement($group->getMembers());

            $message = new Message();
            $message->setAuthor($author);
            $message->setToGroup(true);
            $message->setTarget($group);
            $message->setContent($faker->sentence());
            $manager->persist($message);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [GroupFixtures::class];
    }
}
