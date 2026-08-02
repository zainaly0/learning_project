<?php
require_once __DIR__ . "/../config/config.php";

function redirect(string $url): void
{
    header("Location: " . BASE_URL . ltrim($url, "/"));
    exit;
}

function url(string $path): string{
    return BASE_URL . ltrim($path, '/');
}
// Parameter $url has no type information available.