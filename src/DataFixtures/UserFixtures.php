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
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setEmail('BCA@example.com');
        $user1->setRoles(['ROLE_SUPERADMIN', 'ROLE_ADMIN']);
        $user1->setPassword($this->passwordEncoder->encodePassword(
            $user1,
            '75t6J19n4v0~y~l'
        ));

        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('admin@example.com');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'L;?<ClWSDE7W0oe'
        ));

        $manager->persist($user2);

        $manager->flush();
    }
}
