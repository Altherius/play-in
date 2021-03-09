<?php


namespace App\Tests\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testSignupCreatesUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');

        $form = $crawler->selectButton('Valider')->form([
            'user_signup[username]' => 'test',
            'user_signup[email]' => 'test@play-in.com',
            'user_signup[plainPassword][first]' => 'T3sttest',
            'user_signup[plainPassword][second]' => 'T3sttest'
        ]);

        $client->submit($form);
        self::assertResponseRedirects('/');
    }

    public function testSignupPageStatusCode(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLoginPageStatusCode(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLoginPageRedirectsIfAlreadyLoggedIn(): void
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('user@play-in.com');


        $client->loginUser($user);
        $crawler = $client->request('GET', '/login');

        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testSignupPageRedirectsIfAlreadyLoggedIn(): void
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('user@play-in.com');

        $client->loginUser($user);
        $crawler = $client->request('GET', '/signup');

        self::assertResponseRedirects('/');
    }
}