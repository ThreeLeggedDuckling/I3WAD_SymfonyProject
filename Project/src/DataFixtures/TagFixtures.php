<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Constraints\Choice;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $games = ['Dungeons & Dragons', 'Vampire: the Masquerade', 'Degenesis', 'Mausritter', 'City of Mist'];
        $genres = ['fantasy', 'medieval fantasy', 'horror', 'science fiction', 'animal', 'strategy', 'narrative', 'realist', 'historic', 'space'];
        $levels = ['first timer', 'beginner', 'beginner friendly', 'experimented'];
        $modalities = ['irl', 'remote', 'mixed'];

        $types = [
            'game' => $games,
            'genre' => $genres,
            'level' => $levels,
            'modality' => $modalities
        ];

        foreach($types as $type => $choice){
            foreach($choice as $k => $v){
                $tag = new Tag();
                $tag->setName($v);
                $tag->setType($type);
        
                $this->addReference("tag" . ucfirst($type) . $k, $tag);
                $manager->persist($tag);
            }
        }

        $manager->flush();
    }
}
