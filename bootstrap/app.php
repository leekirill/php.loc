<?php

function getEnvs()
{
    return $_ENV;
}

function boot(): void
{
    date_default_timezone_set(getenv('APP_TIMEZONE') ?: 'UTC');
}

boot();

function render(string $view, array $context = []): string
{
    ob_start(null, 2048);
    $content = template($view, $context);
    require_once dirname(__DIR__, 1) . '/views/layouts/app.php';
    return str_replace("{{ content }}", $content, ob_get_clean());
}

function template(string $view, array $context) : string
{
    $file = dirname(__DIR__, 1) . "/views/$view.php";

    if (!file_exists($file)) {
        die("The file ($file) could not be found.");
    }

    ob_start();
    extract($context);
    include ($file);
    return ob_get_clean();

}

function uri(): string
{
    return $_SERVER['REQUEST_URI'];
}

$routes = require_once dirname(__DIR__, 1) . '/config/routes.php';
$request = trim(uri(), '/');

if (array_key_exists($request, $routes)) {
    require_once dirname(__DIR__, 1) . "/app/Controllers/$routes[$request].php";

    $controller = new $routes[$request]();
    $controller->index();
} else {
    require_once dirname(__DIR__, 1) . "/app/Controllers/ErrorController.php";

    $controller = new ErrorController();
    $controller->index();
}