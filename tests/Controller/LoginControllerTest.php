<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function test_sucessful_login(): void
    {
        $validUsername = "lucasmmduran@gmail.com";
        $validPassword = "123456";

        $client = static::createClient();
        $client->request('POST', '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => $validUsername,
            'password' => $validPassword,
        ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        $responseContent = $client->getResponse()->getContent();
        $responseData = json_decode($responseContent, true);

        $this->assertArrayHasKey('token', $responseData);
        $this->assertNotEmpty($responseData['token']);
    }

    public function test_empty_password_login(): void
    {
        $username = "lucasmmduran@gmail.com";
        $password = "";

        $client = static::createClient();
        $client->request('POST', '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => $username,
            'password' => $password,
        ]));

        $this->assertResponseStatusCodeSame(400);
        
        $responseContent = $client->getResponse()->getContent();
        $responseData = json_decode($responseContent, true);
        
        $this->assertStringContainsString('The key "password" must be a non-empty string.', $responseData['detail']);
    }

    public function test_invalid_credentials_login(): void
    {
        $username = "lucasmmduran@gmail.com";
        $password = "invalid_password";

        $client = static::createClient();
        $client->request('POST', '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => $username,
            'password' => $password,
        ]));

        $this->assertResponseStatusCodeSame(401);
        $responseContent = $client->getResponse()->getContent();

        $responseData = json_decode($responseContent, true);
        
        $this->assertStringContainsString("Usuario o contraseña incorrectos. Por favor, intenta nuevamente.", $responseData['message']);
    }
}
