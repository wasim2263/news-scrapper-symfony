<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $admin_user = new User();
        $admin_user->setUsername('admin');
        $password = $this->hasher->hashPassword($admin_user, 'pass_1234');
        $admin_user->setPassword($password);
        $admin_user->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin_user);
        $manager->flush();

        $moderator_user = new User();
        $moderator_user->setUsername('moderator');
        $moderator_user->setRoles(['ROLE_MODERATOR']);
        $password = $this->hasher->hashPassword($moderator_user, 'pass_1234');
        $moderator_user->setPassword($password);
        $manager->persist($moderator_user);
        $manager->flush();
    }
}
