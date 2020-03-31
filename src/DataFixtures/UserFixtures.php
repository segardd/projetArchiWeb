<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
 public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
 $this->passwordEncoder = $passwordEncoder;
 }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user1= new User();
        $user1->setUsername('admin');
        $user1->setRoles(['ROLE_SUPER_ADMIN']);
        $encryptedpwd=$this->passwordEncoder->encodePassword($user1,'bigboss');
        $user1->setPassword($encryptedpwd);
        $manager->persist($user1);

        $user2= new User();
        $user2->setUsername('secretary');
        $user2->setRoles(['ROLE_ADMIN']);
        $encryptedpwd=$this->passwordEncoder->encodePassword($user2,'coucou');
        $user2->setPassword($encryptedpwd);
        $manager->persist($user2);

        $user3= new User();
        $user3->setUsername('user');
        $user3->setRoles(['ROLE_USER']);
        $encryptedpwd=$this->passwordEncoder->encodePassword($user3,'user');
        $user3->setPassword($encryptedpwd);
        $manager->persist($user3);

        $manager->flush();
    }
}
