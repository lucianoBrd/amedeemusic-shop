<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ApiService
{
    public function __construct(
        private HttpClientInterface $client,
        private ContainerBagInterface $params,
    )
    {
    }

    public function get(string $page): array
    {
        $response = $this->client->request(
            'GET',
            $this->params->get('app.api.url') . $page, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]
        );

        return $response->toArray();
    }

    public function post(string $page, array $body = []): array
    {
        $response = $this->client->request(
            'POST',
            $this->params->get('app.api.url') . $page, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'body' => $body
            ]
        );

        return $response->toArray();
    }
}
