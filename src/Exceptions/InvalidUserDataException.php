<?php

namespace Joshuahales\UserApiPackage\Exceptions;

/**
 * Class InvalidUserDataException
 * 
 * This exception is thrown when invalid or incomplete user data is provided. 
 * It allows for passing along the invalid data for better error reporting and debugging.
 */
class InvalidUserDataException extends \Exception
{
    private array $invalidData; // Stores the invalid user data that triggered the exception

    /**
     * InvalidUserDataException constructor.
     * 
     * @param string $message - The error message to display (default is "Invalid user data provided.").
     * @param int $code - The error code (default is 400 for bad request).
     * @param \Throwable|null $previous - A previous exception, if any (default is null).
     * @param array $invalidData - The user data that was considered invalid (default is an empty array).
     */
    public function __construct($message = "Invalid user data provided.", $code = 400, \Throwable $previous = null, array $invalidData = [])
    {
        $this->invalidData = $invalidData;
        // Pass the message, code, and previous exception to the parent Exception class
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the invalid data that caused the exception.
     * 
     * This method allows developers to access the specific data that was considered invalid, 
     * providing more context for debugging and error reporting.
     * 
     * @return array - An array containing the invalid data.
     */
    public function getInvalidData(): array
    {
        return $this->invalidData;
    }
}