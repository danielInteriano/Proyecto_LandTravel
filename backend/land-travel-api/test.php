<?php

require ('vendor/autoload.php');

use Dotenv\Dotenv;
use React\Http\Server;
use Recoil\React\ReactKernel;
use App\Rutas\Model\ModelRuta;
use App\Tours\Model\ModelTours;
use App\Rutas\Kernel\KernelRutas;
use React\Socket\Server as SocketServer;


$loop = \React\EventLoop\Factory::create();

function hello()
{
    yield;
    return array(1, 2, 3 , 4);
}

function world(Array $a)
{
    $a[0] = ['a' => 'b'];
    yield;
}

$env = Dotenv::createImmutable(__DIR__);
$env->load();
$uri = getenv('DB_USER'). ':' . getenv('DB_PASS') . '@'. getenv('DB_HOST'). '/' . getenv('DB_NAME');
$mysql = new \React\MySQL\Factory($loop);
$conexion = $mysql->createLazyConnection($uri);


ReactKernel::start(function() use ($loop, $conexion) {
    $server = new KernelRutas($loop, $conexion, '1');
    yield;
    return $server;
});





$loop->run();