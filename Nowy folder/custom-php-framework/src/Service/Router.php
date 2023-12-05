<?php

namespace App\Service;

class Router
{
    private $routes = [];

    public function addRoute(string $path, string $action)
    {
        $this->routes[$path] = $action;
    }

    public function matchRoute(string $path): ?string
    {
        return $this->routes[$path] ?? null;
    }

    public function generatePath(string $action, ?array $params = []): string
    {
        $query = $action ? http_build_query(array_merge(['action' => $action], $params)) : null;
        $path = "/index.php" . ($query ? "?$query" : null);
        return $path;
    }

    public function redirect($path): void
    {
        header("Location: $path");
    }
}