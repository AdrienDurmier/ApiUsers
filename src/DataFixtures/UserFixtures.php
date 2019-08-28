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
        $user->addRole('ROLE_AGENDA_ADMIN');
        $user->setPassword($this->encoder->encodePassword($user, 'test'));
		$manager->persist($user);
		
		$user1 = new User();
        $user1->setUsername('k.herpelinck@gmail.com');
        $user1->setFirstname('Kathy');
        $user1->setLastname('Herpelink');
        $user1->setEmail('k.herpelinck@gmail.com');
        $user1->setEnabled(1);
        $user1->addRole('ROLE_ADMIN');
        $user1->addRole('ROLE_PLANESWALKERS_ADMIN');
        $user1->addRole('ROLE_AGENDA_ADMIN');
        $user1->setPassword($this->encoder->encodePassword($user1, 'test'));
		$manager->persist($user1);
		
		$user2 = new User();
        $user2->setUsername('achille.durmier@gmail.com');
        $user2->setFirstname('Achille');
        $user2->setLastname('Durmier');
        $user2->setEmail('achille.durmier@gmail.com');
        $user2->setEnabled(1);
        $user2->addRole('ROLE_ADMIN');
        $user2->addRole('ROLE_PLANESWALKERS_ADMIN');
        $user2->addRole('ROLE_AGENDA_ADMIN');
        $user2->setPassword($this->encoder->encodePassword($user2, 'test'));
		$manager->persist($user2);
		
		$user3 = new User();
        $user3->setUsername('clemence.charbonnel@gmail.com');
        $user3->setFirstname('Clémence');
        $user3->setLastname('Charbonnel');
        $user3->setEmail('clemence.charbonnel@gmail.com');
        $user3->setEnabled(1);
        $user3->addRole('ROLE_ADMIN');
        $user3->addRole('ROLE_PLANESWALKERS_ADMIN');
        $user3->addRole('ROLE_AGENDA_ADMIN');
        $user3->setPassword($this->encoder->encodePassword($user3, 'test'));
		$manager->persist($user3);
        
        $manager->flush();
    }
}
