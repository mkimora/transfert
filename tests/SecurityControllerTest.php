<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/partenaire');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains(['CONTENT_TYPE'=>"application/json"],
        '{"nompartenaire":"service a","raisonSocial": "sa","ninea": "1000","numcompte": 2,"solde":2000000,"adresse":"dakar","etat":"blocquer"}');
    }
}
