<?php

$baseDirectory = __DIR__ . '/../../';
$dotenv = Dotenv\Dotenv::createImmutable($baseDirectory);
$envFile = $baseDirectory . '.env';
if (file_exists($envFile)) {
    $dotenv->load();
}
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_PORT', 'SECRET_KEY']);