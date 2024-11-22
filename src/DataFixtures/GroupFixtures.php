<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $usersArr = [];
        for ($i = 0; $i < 29; $i++) {
            $usersArr[] = $this->getReference("user{$i}");
        }

        $dummy = [
            'The Dicey Alliance',
            'Critical Hit Crew',
            'Starship Syndicate',
            'Wasteland Wanderers',
            'Mystic & Mechs',
            'Post-Apoc Adventurers',
            'Dungeon Delvers United',
            'Cosmic Conquerors',
            'The Last Safe Haven',
            'Neon Knights',
        ];

        $adjectives = ['awsome', 'phenomenal', 'astral'];
        $nouns = ['company', 'fellowship', 'fleet'];
        $faker = Factory::create();

        for ($i = 0; $i < 7; $i++) {
            $members = $faker->randomElements($usersArr, 4);

            $group = new Group();
            $group->setName($faker->randomElement($dummy));
            unset($dummy[array_search($group->getName(), $dummy)]);
            
            foreach ($members as $member) {
                $group->addMember($member);
            }
            $group->addAdmin($faker->randomElement($group->getMembers()));

            $this->addReference("group{$i}", $group);
            $manager->persist($group);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }

}
