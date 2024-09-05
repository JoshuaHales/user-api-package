<?php

namespace Joshuahales\UserApiPackage\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Joshuahales\UserApiPackage\UserApiService;

class UserApiServiceIntegrationTest extends TestCase
{
    private $userApiService;

    protected function setUp(): void
    {
        // Use the real Guzzle client for integration tests
        $this->userApiService = new UserApiService();
    }

    /**
     * Test retrieving a user by ID from the real API.
     */
    public function testGetUserById()
    {
        // Make a real request to the API
        $user = $this->userApiService->getUserById(1);

        // Assert that the response is a valid user DTO and check some fields
        $this->assertInstanceOf(\Joshuahales\UserApiPackage\UserDTO::class, $user);
        $this->assertEquals(1, $user->toArray()['id']);
    }

    /**
     * Test retrieving a paginated list of users from the real API.
     */
    public function testGetPaginatedUsers()
    {
        // Make a real request to the API
        $users = $this->userApiService->getPaginatedUsers(1);

        // Assert the users array is valid
        $this->assertIsArray($users);
        $this->assertGreaterThan(0, count($users));
    }

    /**
     * Test creating a user via the real API.
     */
    public function testCreateUser()
    {
        // Make a real request to create a user
        $user = $this->userApiService->createUser('Jane', 'Doe', 'Engineer');

        // Assert that the user creation was successful and an ID was returned
        $this->assertInstanceOf(\Joshuahales\UserApiPackage\UserDTO::class, $user);
        $this->assertNotNull($user->toArray()['id']);
    }
}