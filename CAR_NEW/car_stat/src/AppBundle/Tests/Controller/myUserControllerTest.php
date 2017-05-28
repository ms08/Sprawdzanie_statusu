<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class myUserControllerTest extends WebTestCase
{
    public function testShowonecar()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/showOneCar');
    }

    public function testShowallcars()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/showAllCars');
    }

    public function testMain()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'user/main');
    }

}
