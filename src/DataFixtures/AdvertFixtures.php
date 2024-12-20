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
        $faker = Factory::create();
        
        for ($i = 0; $i < 40; $i++) {
            $advert = new Advert();
            $advert->setAuthor($this->getReference('user' . rand(0, 19)));
            $advert->setPublishDate($faker->dateTimeBetween('-2 months'));
            $advert->setOpen(true);
            $advert->setContent($faker->paragraph(rand(4, 10)));

            // jeu défini ou genre
            if ($i % 2 == 1) {
                $advert->addTag($this->getReference('tagGame' . rand(0, 4)));
            }
            else {
                $advert->addTag($this->getReference('tagGenre' . rand(0, 9)));
            }
            $advert->addTag($this->getReference('tagLevel' . rand(0, 3)));

            // modalité
            $modality = $this->getReference('tagModality' . rand(0, 2));
            $advert->addTag($modality);
            if ($modality->getName() != 'remote') {
                $advert->setArea($faker->city());
            }

            $this->addReference("advert{$i}", $advert);
            $manager->persist($advert);
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TagFixtures::class,
            UserFixtures::class,
        ];
    }
}
