<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/partenaire',[],[],['CONTENT_TYPE'=>"application/json"],
        '{"nompartenaire":"service a",
            "raisonSocial":"SA",
            "ninea": "1000",
            "numcompte": 2,
            "solde":2000000,
            "adresse":"dakar",
            "etat":"blocquer"}');
         $test=$client->getResponse()->getStatusCode();
         var_dump($test);
        $this->assertSame(201,$test);
        //$this->assertSelectorTextContains();
    }
}
