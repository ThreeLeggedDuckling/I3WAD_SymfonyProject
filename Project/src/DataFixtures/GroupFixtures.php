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
        $adjectives = ['awsome_', 'phenomenal_', 'astral_'];
        $nouns = ['company', 'fellowship', 'fleet'];
        $faker = Factory::create();

        for($i = 0; $i < 4; $i++){
            $group = new Group();
            $group->setName('the_' . $faker->randomElement($adjectives) . $faker->randomElement($nouns));
            
            for($j = 0; $j < 3; $j++){
                $group->addMember($this->getReference('user' . rand(0, 9)));
            }

            $manager->persist($group);
        }

        $manager->flush();
    }

    public function getDependencies(){
        return [UserFixtures::class];
    }

}
