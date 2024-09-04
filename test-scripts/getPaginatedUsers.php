<?php

require '../vendor/autoload.php';

use Joshuahales\UserApiPackage\UserApiService;

// Instantiate the UserApiService
$userApiService = new UserApiService();

// Retrieve a paginated list of users
try {
    $users = $userApiService->getPaginatedUsers(1);
    foreach ($users as $user) {
        print_r($user->toArray());
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
