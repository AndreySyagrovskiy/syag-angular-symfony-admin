<?php

namespace Syagr\AuthorizationRestApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorizationControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        echo "Login and password good\r\n";
        $client->request(
            'POST',
            '/api/authorization/login',
            array(
                'login' => 'user',
                'password' => 'user',
                'appToken' => 'app2121d3ds34gg33asgr23e23ce2asa',
            )
        );

        $responseArray = json_decode((string)$client->getResponse()->getContent(), true);

        var_dump($responseArray);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('user', $responseArray);
        $this->assertArrayHasKey('token', $responseArray);
        $this->assertArrayHasKey('permissions', $responseArray);
        $this->assertEquals('syagrovskiyandriy@gmail.com', $responseArray['user']['email']);
        $this->assertEquals('user', $responseArray['user']['username']);


        echo "Wrong login\r\n";
        $client->request(
            'POST',
            '/api/authorization/login',
            array(
                'login' => 'user1',
                'password' => 'user',
                'appToken' => 'app2121d3ds34gg33asgr23e23ce2asa',
            )
        );

        $responseArray1 = json_decode((string)$client->getResponse()->getContent(), true);

        var_dump($responseArray1);
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('error', $responseArray1);


        echo "Wrong password\r\n";
        $client->request(
            'POST',
            '/api/authorization/login',
            array(
                'login' => 'user1',
                'password' => 'user',
                'appToken' => 'app2121d3ds34gg33asgr23e23ce2asa',
            )
        );
        $responseArray2 = json_decode((string)$client->getResponse()->getContent(), true);

        var_dump($responseArray2);
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('error', $responseArray2);


        echo "Invalid application token\r\n";
        $client->request(
            'POST',
            '/api/authorization/login',
            array(
                'login' => 'user',
                'password' => 'user',
                'appToken' => 'wrong',
            )
        );

        $responseArray3 = json_decode((string)$client->getResponse()->getContent(), true);

        var_dump($responseArray3);
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('error', $responseArray3);


        echo "Short password\r\n";
        $client->request(
            'POST',
            '/api/authorization/login',
            array(
                'login' => 'user',
                'password' => 'u',
                'appToken' => 'app2121d3ds34gg33asgr23e23ce2asa',
            )
        );

        $responseArray4 = json_decode((string)$client->getResponse()->getContent(), true);

        var_dump($responseArray4);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('error', $responseArray4);
        $this->assertArrayHasKey('errors', $responseArray4);


        echo "Short login\r\n";
        $client->request(
            'POST',
            '/api/authorization/login',
            array(
                'login' => 'u',
                'password' => 'user',
                'appToken' => 'app2121d3ds34gg33asgr23e23ce2asa',
            )
        );

        $responseArray5 = json_decode((string)$client->getResponse()->getContent(), true);

        var_dump($responseArray5);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('error', $responseArray5);
        $this->assertArrayHasKey('errors', $responseArray5);
    }

    public function testGetUserDataByToken()
    {
        $client = static::createClient();

        echo "Login and password good\r\n";
        $client->request(
            'POST',
            '/api/authorization/login',
            array(
                'login' => 'user',
                'password' => 'user',
                'appToken' => 'app2121d3ds34gg33asgr23e23ce2asa',
            )
        );

        $responseArray = json_decode((string)$client->getResponse()->getContent(), true);

        var_dump($responseArray);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('user', $responseArray);
        $this->assertArrayHasKey('token', $responseArray);

        $token = $responseArray['token'];
        unset($responseArray);

        echo " Good token\r\n";
        $client->request(
            'GET',
            '/api/authorization/userdata/'.$token
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        echo 'Stauts code '.$client->getResponse()->getStatusCode()."\r\n \r\n";

        echo "Short token\r\n";
        $client->request(
            'GET',
            '/api/authorization/userdata/27b17'
        );
        echo 'Stauts code '.$client->getResponse()->getStatusCode()."\r\n \r\n";
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        echo "Wrong token\r\n";
        $client->request(
            'GET',
            '/api/authorization/userdata/wrong'.$token
        );
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        echo 'Stauts code '.$client->getResponse()->getStatusCode()."\r\n \r\n";
        $responseArray = json_decode((string)$client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $responseArray);

        var_dump($responseArray);
    }
}
