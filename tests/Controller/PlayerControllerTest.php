<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private $content;
    private static $identifier;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/player/create');

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    public function testDisplay(): void
    {
        $this->client->request('GET', '/player/display/' . self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    public function testRedirectIndex(): void
    {
        $this->client->request('GET', '/player');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/player/index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testModify(): void
    {
        $this->client->request('PUT', '/player/update/' . self::$identifier);
        $this->assertJsonResponse();
    }

    public function testDelete(): void
    {
        $this->client->request('DELETE', '/player/delete/' . self::$identifier);
        $this->assertJsonResponse();
    }

    public function testBadIdentifier(): void
    {
        $this->client->request('GET', '/player/display/badIdentifier');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    public function testInexistingIdentifier(): void
    {
        $this->client->request('GET', '/player/display/1345');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    public function assertJsonResponse(): void
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    public function assertError404($statusCode): void
    {
        $this->assertEquals(404, $statusCode);
    }

    /**
     * Asserts that 'identifier'
     * is present in the Response
     */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('id', $this->content);
    }

    /**
     * Defines identifier
     */
    public function defineIdentifier()
    {
        self::$identifier = $this->content['id'];
    }
}
