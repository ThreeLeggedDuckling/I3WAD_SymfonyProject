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
        $faker = Factory::create();
        $dummy = [
            'Cyborg_Adventurer', 'Quantum_Sorcerer', 'Starship_Pirate',
            'Bio_Engineer-X', 'Neon_Shadow', 'Wasteland_Stalker',
            'Mech_Warrior_X', 'Rogue_Astronaut', 'Cyberpunk_Neon',
            'Galactic_Bounty', 'Mutant_Outlaw', 'Void_Explorer',
            'Quantum_Mystic', 'Post_Apoc_Ranger', 'Space-Faring_Templar',
            'Android_Scout', 'Neon_Mercenary', 'Plague_Doctor_X',
            'Techno_Sorcerer', 'Galactic_Warden', 'Urban_Detective',
            'Psi_Monk', 'Starborn_Warrior', 'Retro_Hacker',
            'Outlaw_Engineer', 'Noir_Investigator', 'Galactic_Freelancer',
            'Mech-Ranger', 'Wasteland_Vigilante', 'SkyPirate_X',
        ];

        for ($i = 0; $i < 30; $i++) {
            
            $user = new User();
            $user->setEmail("user{$i}@mail.net");
            $user->setPassword($this->passwordHasher->hashPassword($user, "test"));
            $user->setUsername($faker->randomElement($dummy));
            unset($dummy[array_search($user->getUsername(), $dummy)]);

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
