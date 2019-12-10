<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
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
        // Création d’un utilisateur de type “suscriber”
        $subscriber = new User();
        $subscriber->setEmail('subscriber@monsite.com');
        $subscriber->setRoles(['ROLE_SUBSCRIBER']);
        $subscriber->setUsername('subscriber');
        $subscriber->setBio('I am the subscriber');
        $subscriber->setPassword($this->passwordEncoder->encodePassword(
            $subscriber,
            'suscriber'
        ));

        $manager->persist($subscriber);

        // Création d’un utilisateur de type “auteur”
        $subscriberauthor = new User();
        $subscriberauthor->setEmail('subscriberauthor@monsite.com');
        $subscriberauthor->setRoles(['ROLE_SUBSCRIBER']);
        $subscriberauthor->setUsername('autheur');
        $subscriberauthor->setBio('I am the autheur');
        $subscriberauthor->setPassword($this->passwordEncoder->encodePassword(
            $subscriberauthor,
            'autheur'
        ));

        $manager->persist($subscriberauthor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setBio('I am the admin');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));

        $manager->persist($admin);

        // Sauvegarde des 3 nouveaux utilisateurs :
        $manager->flush();
    }
}
