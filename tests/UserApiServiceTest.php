<?php

namespace Joshuahales\UserApiPackage\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Joshuahales\UserApiPackage\UserDTO;
use Joshuahales\UserApiPackage\UserApiService;

class UserApiServiceTest extends TestCase
{
    private $userApiService;

    protected function setUp(): void
    {
        // Use the real Guzzle client
        $client = new Client(['base_uri' => 'https://reqres.in/api/']);
        $this->userApiService = new UserApiService($client);
    }

    public function testGetUserById()
    {
        $user = $this->userApiService->getUserById(1);

        // Assertions
        $this->assertInstanceOf(UserDTO::class, $user);
        $this->assertEquals('George', $user->toArray()['first_name']);
        $this->assertEquals('Bluth', $user->toArray()['last_name']);
        $this->assertEquals('Unknown', $user->toArray()['job']); // Because the job is not provided by the API, we use the default value 'Unknown'
    }

    public function testGetPaginatedUsers()
    {
        $users = $this->userApiService->getPaginatedUsers(1);

        // Assertions
        $this->assertIsArray($users);
        $this->assertGreaterThan(0, count($users));
        foreach ($users as $user) {
            $this->assertInstanceOf(UserDTO::class, $user);
        }
    }

    public function testCreateUser()
    {
        $user = $this->userApiService->createUser('John', 'Doe', 'Developer');

        // Assertions
        $this->assertInstanceOf(UserDTO::class, $user);
        $this->assertEquals('John', $user->toArray()['first_name']);
        $this->assertEquals('Doe', $user->toArray()['last_name']);
        $this->assertEquals('Developer', $user->toArray()['job']);
        $this->assertNotNull($user->toArray()['id']); // Ensure an ID is returned
    }
}