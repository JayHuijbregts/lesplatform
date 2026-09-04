<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));

    $file = dirname(__DIR__)
        . '/app/'
        . str_replace('\\', '/', $relativeClass)
        . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Controllers\HomeController;

$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    default:
        http_response_code(404);
        echo '404 - Pagina niet gevonden';
        break;
}