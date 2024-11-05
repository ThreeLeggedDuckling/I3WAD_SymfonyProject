<?php

namespace App\DataFixtures;

use App\Entity\File;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FileFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $campaign = $this->getReference('campaign' . rand(0, 3));
        $gMembers = $campaign->getPlayingGroup()->getMembers();
        $faker = Factory::create();

        foreach($gMembers as $member){
            $file = new File();
            $file->setCampaign($campaign);
            $file->setAuthor($member);
            $file->setCreationDate(new DateTime());

            if($member === $campaign->getMaster()){
                $file->setName('Campaign progess sheet');
                $file->setType('scenario');
                $file->setFormat('doc');
            } else{
                $file->setName($member->getUsername() . '\'s sheet');
                $file->setType('character sheet');
                $file->setFormat('pdf');
            }

            $manager->persist($file);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampaignFixtures::class];
    }
}
