<?php

namespace App\DataFixtures;

Use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('josheorteg@gmail.com');

        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['users'];
    }
}
