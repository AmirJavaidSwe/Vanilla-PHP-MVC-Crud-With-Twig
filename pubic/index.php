<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config/config.php');
use Controller\CourseController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Model\CourseModel;


$loader = new FilesystemLoader('../app/View/templates');
$twig = new Environment($loader);

// Pass the database connection when creating CourseModel instance
$courseModel = new CourseModel($conn);

// Get the request URI, remove query strings
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = require(__DIR__ . '/../routes/routes.php');

// Loop through the defined routes
foreach ($routes as $route => $action) {
    // Replace {id} with a regular expression to match numbers
    $pattern = str_replace('{id}', '(\d+)', $route);

    // Add start and end anchors to ensure a full match
    $pattern = '#^' . $pattern . '$#';

    // Check if the request URI matches the pattern
    if (preg_match($pattern, $requestUri, $matches)) {
        list($controllerName, $method) = explode('@', $action);

        // Construct the controller class name
        $controllerClassName = 'Controller\\' . $controllerName;

        // Check if the controller class exists
        if (class_exists($controllerClassName)) {
            $controller = new $controllerClassName($twig, $courseModel);

            // Call the controller action with or without ID parameter
            if (isset($matches[1])) {
                $controller->$method($matches[1]);
            } else {
                $controller->$method();
            }

            // Exit to prevent further processing
            exit;
        }
    }
}

// If no matching route or controller action is found, display an error message
http_response_code(404);
echo 'Route not found.';