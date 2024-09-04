<?php

namespace Joshuahales\UserApiPackage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UserApiService
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client(['base_uri' => 'https://reqres.in/api/']);
    }

    public function getUserById(int $id): UserDTO
    {
        try {
            $response = $this->client->get("users/{$id}");
            $data = json_decode($response->getBody()->getContents(), true);

            return new UserDTO($data['data']);
        } catch (RequestException $e) {
            // Handle API exception and convert to domain-specific exception
            throw new \Exception("Failed to retrieve user: " . $e->getMessage());
        }
    }

    public function getPaginatedUsers(int $page = 1): array
    {
        try {
            $response = $this->client->get("users", ['query' => ['page' => $page]]);
            $data = json_decode($response->getBody()->getContents(), true);

            return array_map(fn($userData) => new UserDTO($userData), $data['data']);
        } catch (RequestException $e) {
            throw new \Exception("Failed to retrieve users: " . $e->getMessage());
        }
    }

    public function createUser(string $firstName, string $lastName, string $job): UserDTO
    {
        try {
            $response = $this->client->post('users', [
                'json' => [
                    'first_name' => $firstName, 
                    'last_name' => $lastName, 
                    'job' => $job
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return new UserDTO([
                'id' => $data['id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'job' => $data['job']
            ]);
        } catch (RequestException $e) {
            throw new \Exception("Failed to create user: " . $e->getMessage());
        }
    }
}