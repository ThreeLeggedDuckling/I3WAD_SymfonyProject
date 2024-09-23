<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AdvertFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $levels = ['first timer', 'beginner', 'beginner friendly', 'experimented'];
        $faker = Factory::create();

        for($i = 0; $i < 3; $i++){
            $advert = new Advert();
            $advert->setAuthor($this->getReference('user' . rand(0, 9)));
            $advert->setPublishDate(new \DateTime());
            $advert->setOpen(true);
            $advert->setLevel($faker->randomElement($levels));
            $advert->setContent($faker->paragraph());

            $this->addReference("advert{$i}", $advert);
            $manager->persist($advert);
        }

        $manager->flush();
    }

    public function getDependencies(){
        return [UserFixtures::class];
    }
}
