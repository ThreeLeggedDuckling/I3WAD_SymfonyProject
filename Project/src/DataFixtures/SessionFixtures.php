<?php

namespace App\DataFixtures;

use App\Entity\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 7; $i++){
            $session = new Session();
            $session->setCampaign($this->getReference('campaign' . rand(0, 3)));
            $session->setScheduled($faker->dateTimeThisYear());
            $session->setRunTime(rand(90, 240));
            
            $manager->persist($session);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampaignFixtures::class];
    }
}
