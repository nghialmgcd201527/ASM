<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $adminUser = new User();
        $adminUser->setEmail("admin@localhost.io")->setName("admin")->setPhoneNumber("113")->setGender("Male and Female");
        $password = $this->hasher->hashPassword( $adminUser, "password123");
        $adminUser->setPassword($password)->setRoles(["ROLE_ADMIN"]);
        $manager->persist($adminUser);
        $manager->flush();
    }
}
