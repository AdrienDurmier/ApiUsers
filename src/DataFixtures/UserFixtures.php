<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('a.durmier@gmail.com');
        $user->setFirstname('Adrien');
        $user->setLastname('Durmier');
        $user->setEmail('a.durmier@gmail.com');
        $user->setEnabled(1);
        $user->addRole('ROLE_ADMIN');
        $user->addRole('ROLE_PLANESWALKERS_ADMIN');
        $user->setPassword($this->encoder->encodePassword($user, 'test'));

        $manager->persist($user);
        $manager->flush();
    }
}
