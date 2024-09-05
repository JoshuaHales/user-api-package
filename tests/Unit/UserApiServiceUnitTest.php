<?php

namespace Joshuahales\UserApiPackage\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Joshuahales\UserApiPackage\UserDTO;
use GuzzleHttp\Exception\RequestException;
use Joshuahales\UserApiPackage\UserApiService;
use Joshuahales\UserApiPackage\Exceptions\UserNotFoundException;
use Joshuahales\UserApiPackage\Exceptions\InvalidUserDataException;
use Joshuahales\UserApiPackage\Exceptions\ApiConnectionException;

class UserApiServiceUnitTest extends TestCase
{
    private $userApiService;

    /**
     * Set up the test case by initializing the real Guzzle client and UserApiService.
     */
    protected function setUp(): void
    {
        // Use the real Guzzle client for actual API requests
        $client = new Client(['base_uri' => 'https://reqres.in/api/']);
        $this->userApiService = new UserApiService($client);
    }

    /**
     * Test fetching a user by ID.
     */
    public function testGetUserById()
    {
        try {
            $user = $this->userApiService->getUserById(1);

            // Assertions to validate that the data is returned correctly
            $this->assertInstanceOf(UserDTO::class, $user); // Validate object type
            $this->assertEquals('George', $user->toArray()['first_name']); // Validate first name
            $this->assertEquals('Bluth', $user->toArray()['last_name']); // Validate last name
            $this->assertEquals('Unknown', $user->toArray()['job']); // Validate job (defaults to "Unknown")

        } catch (UserNotFoundException $e) {
            $this->fail("User not found: " . $e->getMessage());
        } catch (ApiConnectionException $e) {
            $this->fail("API connection failed: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->fail("General error: " . $e->getMessage());
        }
    }

    /**
     * Test fetching a paginated list of users.
     */
    public function testGetPaginatedUsers()
    {
        try {
            $users = $this->userApiService->getPaginatedUsers(1);

            // Assertions to validate user list and data type
            $this->assertIsArray($users);
            $this->assertGreaterThan(0, count($users)); // Ensure there are users in the response

            foreach ($users as $user) {
                $this->assertInstanceOf(UserDTO::class, $user); // Ensure each user is a valid DTO
            }

        } catch (ApiConnectionException $e) {
            $this->fail("API connection failed: " . $e->getMessage());
        } catch (InvalidUserDataException $e) {
            $this->fail("Invalid user data: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->fail("General error: " . $e->getMessage());
        }
    }

    /**
     * Test creating a new user.
     */
    public function testCreateUser()
    {
        try {
            $user = $this->userApiService->createUser('John', 'Doe', 'Developer');

            // Assertions to validate that the user was created successfully
            $this->assertInstanceOf(UserDTO::class, $user);
            $this->assertEquals('John', $user->toArray()['first_name']);
            $this->assertEquals('Doe', $user->toArray()['last_name']);
            $this->assertEquals('Developer', $user->toArray()['job']);
            $this->assertNotNull($user->toArray()['id']); // Ensure an ID is returned

        } catch (InvalidUserDataException $e) {
            $this->fail("Invalid user data: " . $e->getMessage());
        } catch (ApiConnectionException $e) {
            $this->fail("API connection failed: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->fail("General error: " . $e->getMessage());
        }
    }

    /**
     * Test behavior when a user is not found (e.g., invalid ID).
     */
    public function testUserNotFound()
    {
        // Expect UserNotFoundException when fetching a non-existent user
        $this->expectException(UserNotFoundException::class);

        // Test with an invalid user ID to trigger the exception
        $this->userApiService->getUserById(99999); // Assumes this user does not exist
    }

    /**
     * Test behavior when invalid user data is returned by the API.
     */
    public function testInvalidUserDataException()
    {
        // Mock the Guzzle client to return invalid data
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')->willReturn(new \GuzzleHttp\Psr7\Response(200, [], json_encode(['data' => []])));

        // Replace the real client with the mock client
        $this->userApiService = new UserApiService($mockClient);

        // Expect InvalidUserDataException when invalid data is returned
        $this->expectException(InvalidUserDataException::class);

        // Attempt to fetch a user with invalid data
        $this->userApiService->getUserById(1);
    }

    /**
     * Test behavior when fetching a paginated user list and the connection fails.
     */
    public function testPaginatedUsersApiConnectionFailure()
    {
        // Mock the Guzzle client and RequestInterface to simulate a connection failure
        $mockClient = $this->createMock(Client::class);
        $mockRequest = $this->createMock(RequestInterface::class);

        // Simulate a connection error with a valid RequestInterface
        $mockClient->method('get')->willThrowException(new RequestException('Connection error', $mockRequest));

        // Replace the real client with the mock client
        $this->userApiService = new UserApiService($mockClient);

        // Expect ApiConnectionException when fetching a paginated list with a failed connection
        $this->expectException(\Joshuahales\UserApiPackage\Exceptions\ApiConnectionException::class);

        // Attempt to fetch a paginated list of users with the simulated connection failure
        $this->userApiService->getPaginatedUsers(1);
    }
}