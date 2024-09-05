<?php

namespace Joshuahales\UserApiPackage;

use Joshuahales\UserApiPackage\Exceptions\InvalidUserDataException;

/**
 * Class UserDTO
 * 
 * A Data Transfer Object (DTO) representing a user.
 * This class ensures that user data is structured properly and can be serialized into JSON or arrays.
 * It also handles missing or invalid user data by throwing domain-specific exceptions.
 */
class UserDTO implements \JsonSerializable
{
    private $id;
    private $firstName;
    private $lastName;
    private $job;

    /**
     * UserDTO constructor.
     * 
     * @param array $data - The raw user data from the API.
     * 
     * @throws InvalidUserDataException - If essential user data (id, first_name, or last_name) is missing.
     */
    public function __construct(array $data)
    {
        // Check if essential fields are present, otherwise throw a custom exception
        if (!isset($data['id']) || !is_numeric($data['id'])) {
            throw new InvalidUserDataException('Invalid user data: id is missing or not numeric.');
        }
        if (!isset($data['first_name']) || !isset($data['last_name'])) {
            throw new InvalidUserDataException('Invalid user data: first_name or last_name is missing.');
        }

        // Assign values from the input data
        $this->id = $data['id'] ?? null;
        $this->firstName = $data['first_name'] ?? '';
        $this->lastName = $data['last_name'] ?? '';
        $this->job = $data['job'] ?? 'Unknown'; // Default to 'Unknown' if not provided
    }

    /**
     * Converts the UserDTO into a JSON serializable format.
     * 
     * This allows the DTO to be converted into JSON for API responses or other use cases.
     * 
     * @return array - The user data as an associative array.
     */
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'job' => $this->job,
        ];
    }

    /**
     * Converts the UserDTO into an array format.
     * 
     * This provides a convenient way to interact with the user data as an array.
     * 
     * @return array - The user data as an associative array.
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }
}