<?php

namespace Joshuahales\UserApiPackage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Joshuahales\UserApiPackage\Exceptions\UserNotFoundException;
use Joshuahales\UserApiPackage\Exceptions\ApiConnectionException;

class UserApiService
{
    private $client;

    /**
     * Constructor to initialize Guzzle client with base URI
     * for interacting with the external API.
     * 
     * @param Client|null $client - An optional Guzzle client for dependency injection.
     */
    public function __construct(Client $client = null)
    {
        // Initialize the Guzzle client with the API base URI if none provided
        $this->client = $client ?? new Client(['base_uri' => 'https://reqres.in/api/']);
    }

    /**
     * Retrieve a single user by ID.
     * 
     * Handles errors by catching exceptions and throwing domain-specific ones.
     * 
     * @param int $id - The ID of the user to retrieve.
     * @return UserDTO - The user data as a DTO.
     * @throws UserNotFoundException - If the user is not found or the API returns a 404.
     * @throws ApiConnectionException - If there is an API connection issue.
     * @throws InvalidUserDataException - If the user data returned from the API is invalid.
     */
    public function getUserById(int $id): UserDTO
    {
        try {
            // Send the request to the API with http_errors set to false
            // This prevents Guzzle from throwing an exception automatically on HTTP errors
            $response = $this->client->get("users/{$id}", ['http_errors' => false]);

            // Check if the response status code indicates success (200 OK)
            if ($response->getStatusCode() !== 200) {
                // Custom exception for user not found
                throw new UserNotFoundException("User with ID {$id} not found. API returned status code: " . $response->getStatusCode(), 404, null, $id);
            }

            // Parse the response body into an associative array
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the expected user data exists in the response
            if (!isset($data['data'])) {
                // Throw a custom exception if the user data is invalid or missing
                throw new InvalidUserDataException("User ID is missing or invalid.", 0, null, $data);
            }

            // Return the user as a DTO
            return new UserDTO($data['data']);
        } catch (RequestException $e) {
            // Handle connection-related exceptions such as network failures
            throw new ApiConnectionException("API connection failed: " . $e->getMessage(), 500, $e);
        }
    }

    /**
     * Retrieve a paginated list of users.
     * 
     * Handles pagination and ensures errors are caught and communicated clearly.
     * 
     * @param int $page - The page number to retrieve (default is 1).
     * @return array - An array of UserDTO objects representing users.
     * @throws ApiConnectionException - If there is an API connection issue.
     * @throws InvalidUserDataException - If the user data returned from the API is invalid.
     */
    public function getPaginatedUsers(int $page = 1): array
    {
        try {
            // Send the request to the API with http_errors set to false
            // This prevents Guzzle from throwing an exception automatically on HTTP errors
            $response = $this->client->get("users", ['query' => ['page' => $page], 'http_errors' => false]);
    
            // Check if the response status code indicates success (200 OK)
            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Failed to retrieve users. API returned status code: " . $response->getStatusCode());
            }
    
            // Parse the response body into an associative array
            $data = json_decode($response->getBody()->getContents(), true);
    
            // Ensure the user data exists and is valid
            if (!isset($data['data']) || !is_array($data['data'])) {
                // Custom exception for users not found.
                throw new InvalidUserDataException("Invalid or missing user data.");
            }
    
            // Return the list of users as DTOs
            return array_map(fn($userData) => new UserDTO($userData), $data['data']);
        } catch (RequestException $e) {
            // Handle connection-related exceptions such as network failures
            throw new ApiConnectionException("API connection failed: " . $e->getMessage(), 500, $e);
        }
    }    

    /**
     * Create a new user with a first name, last name, and job.
     * 
     * Handles errors and ensures the new user is created successfully.
     * 
     * @param string $firstName - The first name of the user.
     * @param string $lastName - The last name of the user.
     * @param string $job - The user's job title.
     * @return UserDTO - The created user's data as a DTO.
     * @throws ApiConnectionException - If there is an API connection issue.
     * @throws InvalidUserDataException - If the response from the API is invalid.
     */
    public function createUser(string $firstName, string $lastName, string $job): UserDTO
    {
        try {
            // Send the POST request to the API to create a new user
            $response = $this->client->post('users', [
                'json' => [
                    'first_name' => $firstName, 
                    'last_name' => $lastName, 
                    'job' => $job
                ],
                'http_errors' => false // Prevent exceptions from being thrown automatically on HTTP errors
            ]);

            // Check if the response status code indicates success (201 Created)
            if ($response->getStatusCode() !== 201) { // Assuming 201 for user creation
                throw new \Exception("User creation failed. API returned status code: " . $response->getStatusCode());
            }

            // Parse the response body into an associative array
            $data = json_decode($response->getBody()->getContents(), true);

            // Ensure the response contains the ID of the newly created user
            if (!isset($data['id'])) {
                throw new InvalidUserDataException('User creation failed: Invalid response from API.');
            }

            // Return the created user as a DTO
            return new UserDTO([
                'id' => $data['id'],
                'first_name' => $firstName,
                'last_name' => $lastName,
                'job' => $job
            ]);
        } catch (RequestException $e) {
            // Handle connection-related exceptions such as network failures
            throw new ApiConnectionException("Failed to create user: " . $e->getMessage(), 500, $e);
        }
    }
}