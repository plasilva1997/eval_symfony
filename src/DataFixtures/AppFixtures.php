<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $admin_user = new User();
        $admin_user->setEmail('admin@cinema.com');
        $admin_user->setPassword($this->passwordEncoder->encodePassword(
            $admin_user,
            'admin'
        ));
        $admin_user->setRoles(array('ROLE_SUPER_ADMIN'));
        $manager->persist($admin_user);

        $classic_user = new User();
        $classic_user->setEmail('user@cinema.com');
        $classic_user->setPassword($this->passwordEncoder->encodePassword(
            $classic_user,
            'user'
        ));
        $classic_user->setRoles(array('ROLE_USER'));
        $manager->persist($classic_user);

        $manager->flush();
    }
}
