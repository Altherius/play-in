<?php


namespace App\Tests\Entity;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testValidUser(): void
    {
        $user = (new User())
            ->setUsername('User')
            ->setEmail('user@play-in.com');

        self::bootKernel();
        $errors = self::$container->get('validator')->validate($user);
        self::assertCount(0, $errors);
    }

    public function testShortUsername(): void
    {
        $user = (new User())
            ->setUsername('Bob')
            ->setEmail('bob@play-in.com');

        self::bootKernel();
        $errors = self::$container->get('validator')->validate($user);
        self::assertCount(1, $errors);
    }

    public function testInvalidEmail(): void
    {
        $user = (new User())
            ->setUsername('User')
            ->setEmail('invalid_email');

        self::bootKernel();
        $errors = self::$container->get('validator')->validate($user);
        self::assertCount(1, $errors);
    }

    public function testPasswordTooShort(): void
    {
        $user = (new User())
            ->setUsername('User')
            ->setEmail('user@play-in.com')
            ->setPlainPassword('T3st');

        self::bootKernel();
        $errors = self::$container->get('validator')->validate($user);
        self::assertCount(1, $errors);
    }
}