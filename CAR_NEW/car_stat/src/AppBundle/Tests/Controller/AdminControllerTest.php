<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testAddtable()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/addTable');
    }

    public function testDeletetable()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/deleteTable');
    }

}
