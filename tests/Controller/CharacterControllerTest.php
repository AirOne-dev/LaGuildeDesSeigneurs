<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/character/create');

        $this->assertJsonResponse($this->client->getResponse());
    }

    public function testDisplay(): void
    {
        $this->client->request('GET', '/character/display/8032d86185bdf48faf161ed2f88ec0ced2dae056');

        $this->assertJsonResponse($this->client->getResponse());
    }

    public function testRedirectIndex(): void
    {
        $this->client->request('GET', '/character');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/character/index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testBadIdentifier(): void
    {
        $this->client->request('GET', '/character/display/basIdentifier');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    public function assertJsonResponse($response): void
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    public function assertError404($statusCode): void
    {
        $this->assertEquals(404, $statusCode);
    }
}
