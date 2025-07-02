<?php
// This file loads all our secret credentials from the .env file.

require_once __DIR__ . '/../vendor/autoload.php';

// This line tells phpdotenv to look for the .env file in the parent directory (your project root).
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Now, all your variables from .env are available in the $_ENV superglobal.
?>