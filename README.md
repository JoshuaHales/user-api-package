# User API Service Package

**The User API Service package** is a lightweight, framework-agnostic PHP library designed to interact seamlessly with external APIs for user management. It provides a simple yet robust service layer to retrieve and create users via remote APIs, ensuring reliability and ease of integration across various PHP applications, including Laravel, Drupal, and WordPress.

## Key Features

- **Retrieve User by ID**: Fetch a single user by their ID from the API, returned as a structured Data Transfer Object (DTO).
- **Paginated User List**: Retrieve a paginated list of users with efficient API communication and flexible pagination handling.
- **Create New User**: Simplify user creation through the API with easy-to-use methods for specifying user details (first name, last name, job).
- **Domain-Specific Exception Handling**: Convert generic API exceptions into domain-specific ones, making debugging easier and more intuitive.
- **DTO Implementation**: All users are returned as JSON-serializable DTOs, supporting conversion to standard array structures for effortless data manipulation.
- **Fully Testable**: Built with testability in mind, the package includes unit tests to ensure reliability and stability, even when the API is unavailable.

## Installation

To install this package, simply use Composer:

```bash
composer require joshuahales/user-api-package
https://github.com/JoshuaHales/user-api-package
```
## Usage

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

This package is fully testable, with unit tests provided to ensure reliability. To run the tests, execute the following command:

```bash
vendor/bin/phpunit
```

The test suite includes tests for retrieving users, handling paginated responses, creating new users, and exception handling.

## Use Cases

* Seamlessly integrate user management functionalities into any PHP application.
* Provide a reliable service layer that abstracts away the complexities of direct API interactions.
* Ensure consistent and structured user data handling across multiple platforms.

## Compatibility

* PHP Version: 8.2+
* Framework Compatibility: Compatible with any PHP framework or custom PHP project, including Laravel, Drupal, WordPress, etc.

## Contribution

Feel free to fork the repository and make improvements! Pull requests are always welcome.

## License
his package is open-source software licensed under the [MIT license](https://opensource.org/license/mit).