<?php

require '../vendor/autoload.php';

use Joshuahales\UserApiPackage\UserApiService;

// Instantiate the UserApiService
$userApiService = new UserApiService();

// Retrieve a user by ID
try {
    $user = $userApiService->getUserById(1);
    print_r($user->toArray());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
