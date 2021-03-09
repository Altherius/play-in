<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('User')
            ->setPassword($this->encoder->encodePassword($user, 'useruser'))
            ->setEmail('user@play-in.com');

        $admin = new User();
        $admin->setUsername('Admin')
            ->setPassword($this->encoder->encodePassword($admin, 'adminadmin'))
            ->setEmail('admin@play-in.com')
            ->setRoles(['ROLE_SUPER_ADMIN']);

        $manager->persist($user);
        $manager->persist($admin);
        $manager->flush();
    }
}