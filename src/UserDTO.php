<?php

namespace Joshuahales\UserApiPackage;

class UserDTO implements \JsonSerializable
{
    private $id;
    private $firstName;
    private $lastName;
    private $job;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->job = $data['job'] ?? 'Unknown'; // Default to 'Unknown' if not provided
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'job' => $this->job,
        ];
    }

    public function toArray(): array
    {
        return $this->jsonSerialize();
    }
}
