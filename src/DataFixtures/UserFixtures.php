<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $roleUser = $manager->getRepository(Role::class)->findOneBy(['name' => 'USER']);
        if (!$roleUser) {
            $roleUser = new Role();
            $roleUser->setName('USER');
            $manager->persist($roleUser);
            $manager->flush();
        }

        $user = new User();

        $user->setUsername("test_fortify");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'test'
        ));
        $user->addRole($roleUser);
        $user->setNom('test');
        $user->setPrenom('test');
        $user->setAge('20');
        $user->setBio('test bio');
        $user->setEmail('test_fortify@gmail.com');
        $user->setTel('197');

        $manager->persist($user);

        $manager->flush();
    }
}
