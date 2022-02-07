<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    public function testCharacterDisplay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/display');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
