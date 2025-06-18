<?php

namespace App\DataFixtures;

Use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // Cargar el archivo YAML
        $users = Yaml::parseFile(__DIR__.'/yaml/users.yaml');

        foreach ($users['users'] as $data) {
            $user = new User();
            $user->setUsername($data['name']);
            $user->setEmail($data['email']);
            $password = $this->hasher->hashPassword(
                $user,
                $data['password']
            );
            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['users'];
    }
}
