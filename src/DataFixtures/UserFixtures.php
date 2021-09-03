<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture {

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager) {

        $user = new User('yemiwebby', '23412345678');
        $hashedPassword = $this->hasher->hashPassword($user, 'Secret1234!');
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}