<?php

namespace Joshuahales\UserApiPackage\Exceptions;

/**
 * Class UserNotFoundException
 * 
 * This exception is thrown when a requested user cannot be found.
 * It includes the user ID to provide additional context about the error.
 */
class UserNotFoundException extends \Exception
{
    private ?int $userId; // Stores the ID of the user that was not found

    /**
     * UserNotFoundException constructor.
     * 
     * @param string $message - The error message to display (default is "User not found").
     * @param int $code - The error code (default is 404 for "Not Found").
     * @param \Throwable|null $previous - A previous exception, if any (default is null).
     * @param int|null $userId - The ID of the user that could not be found (default is null).
     */
    public function __construct($message = "User not found", $code = 404, \Throwable $previous = null, ?int $userId = null) {
        $this->userId = $userId;
        // Pass the message, code, and previous exception to the parent Exception class
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the ID of the user that was not found.
     * 
     * This method provides the ID of the missing user, offering more context for debugging
     * and logging purposes.
     * 
     * @return int|null - The ID of the user, or null if not applicable.
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }
}