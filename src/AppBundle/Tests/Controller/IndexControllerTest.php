<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests for index controller.
 */
class IndexControllerTest extends WebTestCase
{
    /**
     * Tests main page.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('master', $crawler->filter('h1 em')->text());
    }
}
