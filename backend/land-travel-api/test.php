<?php

require ('vendor/autoload.php');

use Dotenv\Dotenv;
use React\Http\Server;
use Recoil\React\ReactKernel;
use App\Rutas\Model\ModelRuta;
use App\Tours\Model\ModelTours;
use App\Rutas\Kernel\KernelRutas;
use App\Usuarios\Kernel\KernelUsuario;
use App\Usuarios\Usuario;
use React\Socket\Server as SocketServer;


$ciclo = \React\EventLoop\Factory::create();

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
$mysql = new \React\MySQL\Factory($ciclo);
$conexion = $mysql->createLazyConnection($uri);


ReactKernel::start(function() use ($ciclo, $conexion) {
    yield;
    return KernelUsuario::kernelGetByCorreo($ciclo, $conexion, 'adeslive@outlook.es')
        ->then(
            function(Usuario $usuario)
            {
                var_dump($usuario);
            }
        );
});





$ciclo->run();