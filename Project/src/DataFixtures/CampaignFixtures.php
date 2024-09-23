<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CampaignFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $games = ['DnD 5E', 'Vampire', 'Maussritter', 'Pathfinder', 'Insectopia'];
        $faker = Factory::create();

        for($i = 0; $i < 4; $i++){
            $campaign = new Campaign();
            $campaign->setName($faker->sentence(4));
            $campaign->setGame($faker->randomElement($games));
            $campaign->setPlayingGroup($this->getReference('group' . rand(0, 2)));
            $campaign->setMaster($faker->randomElement($campaign->getPlayingGroup()->getMembers()));

            $this->addReference("campaign{$i}", $campaign);
            $manager->persist($campaign);
        }

        $manager->flush();
    }

    public function getDependencies(){
        return [GroupFixtures::class];
    }
}
