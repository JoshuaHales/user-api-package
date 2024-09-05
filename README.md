# User API Service Package

**The User API Service package** is a lightweight, framework-agnostic PHP library designed to interact seamlessly with external APIs for user management. It integrates with the [ReqRes API](https://reqres.in/), a dummy API, to simulate user data management operations. The package provides an intuitive and robust service layer for retrieving and creating users via remote APIs, ensuring reliability and ease of integration across various PHP applications, including Laravel, Drupal, and WordPress.

## Key Features

- **Retrieve User by ID**: Fetch a single user by their ID from the API, returned as a structured Data Transfer Object (DTO).
- **Paginated User List**: Retrieve a paginated list of users with efficient API communication and flexible pagination handling.
- **Create New User**: Simplify user creation through the API with easy-to-use methods for specifying user details (first name, last name, job).
- **Domain-Specific Exception Handling**: Convert generic API exceptions into domain-specific ones, making debugging easier and more intuitive.
- **DTO Implementation**: All users are returned as JSON-serializable DTOs, supporting conversion to standard array structures for effortless data manipulation.
- **Resilient API Communication**: Gracefully handle common API errors, such as connection failures or invalid data, and provide clear error messages to developers using the package.
- **Fully Testable**: Built with testability in mind, the package includes unit and integration tests to ensure reliability and stability, even when the API is unavailable or unstable.

## Installation

To install this package via Composer, you'll need to add the repository to your `composer.json` since it is not on Packagist yet.

1. Open your project's `composer.json` file and add the following:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/JoshuaHales/user-api-package"
        }
    ],
    "require": {
        "joshuahales/user-api-package": "dev-master"
    }
}
```

2. Then, run the following command to install the package:


```bash
composer require joshuahales/user-api-package
https://github.com/JoshuaHales/user-api-package
```

3. Once the package is installed, it will be available in your vendor directory, and you can use it like any other Composer package.

## Usage

This package allows you to easily integrate user management operations into your PHP applications. Below are examples of how to use the provided methods:

1. Retrieving a User by ID

```bash
use Joshuahales\UserApiPackage\UserApiService;

// Initialize the User API Service
$service = new UserApiService();

// Fetch a user by ID
try {
    $user = $service->getUserById(1);
    print_r($user->toArray());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

2. Retrieving a Paginated List of Users

```bash
use Joshuahales\UserApiPackage\UserApiService;

// Initialize the User API Service
$service = new UserApiService();

// Fetch a paginated list of users (e.g., page 1)
try {
    $users = $service->getPaginatedUsers(1);
    foreach ($users as $user) {
        print_r($user->toArray());
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

3. Creating a New User

```bash
use Joshuahales\UserApiPackage\UserApiService;

// Initialize the User API Service
$service = new UserApiService();

// Create a new user
try {
    $user = $service->createUser('John', 'Doe', 'Developer');
    print_r($user->toArray());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Testing

This package is designed to gracefully handle common errors when interacting with remote APIs. It includes custom exceptions for specific scenarios, such as:

- **ApiConnectionException**: Thrown when the API connection fails.
- **InvalidUserDataException**: Thrown when the data received from the API is invalid or missing.
- **UserNotFoundException**: Thrown when a requested user is not found in the API.

By catching and throwing these domain-specific exceptions, the package allows developers to quickly identify and handle issues without relying on generic error messages.

## Testing

This package is fully testable and includes both unit tests and integration tests to ensure its reliability. The unit tests mock API responses to simulate various scenarios, including API downtime or invalid data, while integration tests interact directly with the ReqRes API to validate real-world usage.

Run the tests using PHPUnit:

```bash
vendor/bin/phpunit
```

The test suite includes tests for retrieving users, handling paginated responses, creating new users, and exception handling.

* Retrieving a user by ID, handling successful and error cases.
* Creating a new user with correct or incorrect data.
* Handling API connection failures and invalid data responses.

## Use Cases

* Seamlessly integrate user management functionalities into any PHP application.
* Provide a reliable service layer that abstracts away the complexities of direct API interactions.
* Ensure consistent and structured user data handling across multiple platforms.

## Compatibility

- **PHP Versionn**: 8.2+
- **Framework Compatibility**: The package is designed to be framework-agnostic and works with any PHP framework or custom PHP project, including Laravel, Drupal, WordPress, etc.

## Contribution

Feel free to fork the repository and make improvements! Pull requests are always welcome.

## License
his package is open-source software licensed under the [MIT license](https://opensource.org/license/mit).