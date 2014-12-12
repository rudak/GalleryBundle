<?php

namespace Rudak\GalleryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RenderControllerTest extends WebTestCase
{
    public function testRandimage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/randImage');
    }

    public function testLastimage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/lastImage');
    }

    public function testCarousel()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/carousel');
    }

}
