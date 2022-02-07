<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    public function testDisplay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/display/8032d86185bdf48faf161ed2f88ec0ced2dae056');

        $this->assertJsonResponse($client->getResponse());
    }

    public function testCreate(): void
    {
        $client = static::createClient();
        $client->request('POST', '/character/create');

        $this->assertJsonResponse($client->getResponse());
    }

    public function testRedirectIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function assertJsonResponse($response): void
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
