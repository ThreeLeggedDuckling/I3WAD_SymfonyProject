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
        $nouns = ['table', 'plant', 'starfish'];
        $adjectives = ['red', 'awkward', 'dark'];
        $faker = Factory::create();

        for($i = 0; $i < 10; $i++){
            $user = new User();
            $user->setUsername($faker->randomElement($adjectives) . $faker->randomElement($nouns));
            $user->setEmail("user{$i}@mail.net");
            $user->setPassword($this->passwordHasher->hashPassword($user, "test"));
            
            if($i % 4 == 1){
                $j = floor($i/4);
                $user->setEmail("admin{$j}@mail.net");
                $user->setRoles(['ROLE_ADMIN']);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}