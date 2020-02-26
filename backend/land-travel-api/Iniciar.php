<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use App\Nucleo\Server\ReactServer;

$port = 8080;
$env = Dotenv::createImmutable(__DIR__);
$env->load();
$uri = getenv('DB_USER'). ':' . getenv('DB_PASS') . '@'. getenv('DB_HOST'). '/' . getenv('DB_NAME');

if (PHP_SAPI === 'cli') 
{
    if (!empty($argv[1])) 
    {
        $port = $argv[1];
    }
}

$servers = new ReactServer($port, $uri);
$servers->iniciarCiclo();
