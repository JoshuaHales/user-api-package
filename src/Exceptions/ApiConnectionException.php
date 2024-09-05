<?php

namespace Joshuahales\UserApiPackage\Exceptions;

/**
 * Class ApiConnectionException
 * 
 * This exception is thrown when a connection to the API fails. 
 * It includes the ability to store the URL of the API that caused the failure.
 */
class ApiConnectionException extends \Exception
{
    private ?string $apiUrl; // The API URL where the connection failed

    /**
     * ApiConnectionException constructor.
     * 
     * @param string $message - The error message to display (default is "Failed to connect to API").
     * @param int $code - The HTTP status code (default is 500).
     * @param \Throwable|null $previous - A previous exception, if any (default is null).
     * @param string|null $apiUrl - The API URL that caused the failure (optional).
     */
    public function __construct($message = "Failed to connect to API", $code = 500, \Throwable $previous = null, ?string $apiUrl = null) {
        $this->apiUrl = $apiUrl;
        // Pass the message, code, and previous exception to the parent Exception class
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the API URL where the connection failed.
     * 
     * This can be helpful for debugging purposes, especially in environments with multiple API endpoints.
     * 
     * @return string|null - The API URL or null if no URL was provided.
     */
    public function getApiUrl(): ?string
    {
        return $this->apiUrl;
    }
}