<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\VarDumper\VarDumper;

class AdvertFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 3; $i++){
            $advert = new Advert();
            $advert->setAuthor($this->getReference('user' . rand(0, 9)));
            $advert->setPublishDate(new \DateTime());
            $advert->setOpen(true);
            $advert->setContent($faker->paragraph());

            if($i % 2 == 1){
                $advert->addTag($this->getReference('tagGame' . rand(0, 4)));
            } else{
                $advert->addTag($this->getReference('tagGenre' . rand(0, 9)));
            }
            $advert->addTag($this->getReference('tagLevel' . rand(0, 3)));
            $advert->addTag($this->getReference('tagModality' . rand(0, 2)));
            // if(! $advert->getTags()->contains($this->getReference('tagModality0'))){
            //     $advert->setArea($faker->city());
            // }

            
            $this->addReference("advert{$i}", $advert);
            $manager->persist($advert);
        }
        
        $manager->flush();
    }

    public function getDependencies(){
        return [
            UserFixtures::class,
            TagFixtures::class,
        ];
    }
}
