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
        $faker = Factory::create();
        $games = ['D&D 5E', 'Vampire: the Masquerade', 'Degenesis', 'Mausritter', 'City of Mist', 'Insectopia'];
        $dummy = [
            'Echoes of the Forgotten Stars',
            'The Shattered Realm',
            'Wasteland Requiem',
            'The Cybernetic Uprising',
            'Beneath the Neon Skies',
            'The Chronicles of the Lost Kingdom',
            'Last Light of the Starfarers',
            'The Plagueborn Chronicles',
            'Heirs of the Atomic Dawn',
            'Shadows Over Varnak',
        ];

        for ($i = 0; $i < 10; $i++) {
            $campaign = new Campaign();
            $campaign->setName($faker->randomElement($dummy));
            unset($dummy[array_search($campaign->getName(), $dummy)]);
            $campaign->setGame($faker->randomElement($games));
            $campaign->setPlayingGroup($this->getReference('group' . rand(0, 6)));
            $campaign->setMaster($faker->randomElement($campaign->getPlayingGroup()->getMembers()));

            $this->addReference("campaign{$i}", $campaign);
            $manager->persist($campaign);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [GroupFixtures::class];
    }
}
