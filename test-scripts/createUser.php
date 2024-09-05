<?php

require '../vendor/autoload.php';

use Joshuahales\UserApiPackage\UserApiService;
use Joshuahales\UserApiPackage\Exceptions\ApiConnectionException;
use Joshuahales\UserApiPackage\Exceptions\InvalidUserDataException;

// Instantiate the UserApiService
$userApiService = new UserApiService();

try {
    // Attempt to create a new user with provided details
    $newUser = $userApiService->createUser('Jane', 'Doe', 'Engineer');
    
    // Output the new user information as an array
    print_r($newUser->toArray());
} catch (ApiConnectionException $e) {
    // Handle API connection-related issues
    echo "API Connection Error: " . $e->getMessage() . "\n";
    echo "Failed URL: " . $e->getApiUrl(); // Provide additional context with the API URL
} catch (InvalidUserDataException $e) {
    // Handle invalid user data errors
    echo "Invalid User Data: " . $e->getMessage() . "\n";
    echo "Invalid Data: " . json_encode($e->getInvalidData()); // Provide more details about the invalid data
} catch (Exception $e) {
    // General exception handling for any other errors
    echo "Error: " . $e->getMessage();
}
