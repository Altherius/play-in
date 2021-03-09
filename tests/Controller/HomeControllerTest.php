<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testHomepageStatusCode(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomepageContainsH1(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        self::assertGreaterThan(0, $crawler->filter('h1')->count());
    }
}