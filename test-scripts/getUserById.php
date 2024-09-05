<?php

require '../vendor/autoload.php';

use Joshuahales\UserApiPackage\UserApiService;
use Joshuahales\UserApiPackage\Exceptions\UserNotFoundException;
use Joshuahales\UserApiPackage\Exceptions\ApiConnectionException;
use Joshuahales\UserApiPackage\Exceptions\InvalidUserDataException;

// Instantiate the UserApiService
$userApiService = new UserApiService();

try {
    // Attempt to retrieve a user by their ID (e.g., 1)
    $user = $userApiService->getUserById(1);

    // Output the user's details as an array
    print_r($user->toArray());
} catch (UserNotFoundException $e) {
    // Handle case where user is not found
    echo "User Not Found: " . $e->getMessage() . "\n";
    echo "User ID: " . $e->getUserId(); // Output the user ID that was not found
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