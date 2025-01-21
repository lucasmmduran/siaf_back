<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenService extends WebTestCase
{
	public static function getJwtToken(KernelBrowser $client, string $username = "lucasmmduran@gmail.com", string $password = "123456")
    {
        $client->request('POST', '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => $username,
            'password' => $password,
        ]));

        $responseContent = $client->getResponse()->getContent();
        $responseData = json_decode($responseContent, true);

        if (isset($responseData['token'])) {
            return [
                'token' => $responseData['token'], 
                'client' => $client
            ];
        }

        throw new \Exception('Token not found');
    }
}