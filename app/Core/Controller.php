<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

abstract class Controller
{
    public function __construct()
    {
    }

    protected function view(string $view, array $data = []): void
    {
        $viewPath = dirname(__DIR__) . '/Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new RuntimeException(
                "View '{$view}' bestaat niet."
            );
        }

        extract($data, EXTR_SKIP);

        require $viewPath;
    }
}