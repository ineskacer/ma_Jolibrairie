<?php
namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{

    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager)
    {
        $this->LoadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [
            $email,
            $plainPassword,
            $role
        ]) {
            $user = new User();
            $encodedPassword = $this->userPasswordHasherInterface->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($encodedPassword);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function getUserData()
    {
        yield [
            'ineskacer@gmail.com',
            'ineskacer',
            'ROLE_ADMIN'
        ];
        yield [
            'arezki@gmail.com',
            'arezki',
            'ROLE_USER'
        ];
        yield [
            'ferroudja@gmail.com',
            'ferroudja',
            'ROLE_USER'
        ];
        yield [
            'jasmine@gmail.com',
            'jasmine',
            'ROLE_USER'
        ];
        yield [
            'eden@gmail.com',
            'eden',
            'ROLE_USER'
        ];
        yield [
            'adam@gmail.com',
            'adam',
            'ROLE_USER'
        ];
    }
}
