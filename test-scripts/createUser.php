<?php

require '../vendor/autoload.php';

use Joshuahales\UserApiPackage\UserApiService;

// Instantiate the UserApiService
$userApiService = new UserApiService();

// Create a new user
try {
    $newUser = $userApiService->createUser('Jane', 'Doe', 'Engineer');
    print_r($newUser->toArray());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
