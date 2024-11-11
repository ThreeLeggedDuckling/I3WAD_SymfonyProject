<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $adjectives = ['great', 'awkward', 'dark', 'funny', 'weird', 'awesome', 'ancient'];
        $nouns = ['table', 'plant', 'starfish', 'ninja', 'fruit', 'mess', 'gremlin', 'sock'];
        $faker = Factory::create();

        for ($i = 0; $i < 30; $i++) {
            
            $user = new User();
            $user->setEmail("user{$i}@mail.net");
            $user->setPassword($this->passwordHasher->hashPassword($user, "test"));
            
            switch (rand(1, 5)) {
                case 1:
                    $username = ucfirst($faker->randomElement($adjectives)) . ucfirst($faker->randomElement($nouns));
                    break;
                case 2:
                    $username = $faker->randomElement($adjectives) . '_' . $faker->randomElement($nouns);
                    break;
                case 3:
                    $username = 'The' . ucfirst($faker->randomElement($adjectives)) . ucfirst($faker->randomElement($nouns));
                    break;
                case 4:
                    $username = 'Xx_' . $faker->randomElement($adjectives) . ucfirst($faker->randomElement($nouns)) . '_xX';
                    break;
                case 5:
                    $username = ucfirst($faker->randomElement($adjectives)) . ucfirst($faker->randomElement($nouns)) . rand(11,99);
                    break;
            }
            $user->setUsername($username);

            if ($i % 5 == 1) {
                $j = floor($i/4);
                $user->setEmail("admin{$j}@mail.net");
                $user->setRoles(['ROLE_ADMIN']);
            }

            $this->addReference("user{$i}", $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
