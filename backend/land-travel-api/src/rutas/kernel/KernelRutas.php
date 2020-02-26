<?php

namespace App\Rutas\Kernel;

use App\Respuestas\RespuestaJson;
use App\Rutas\Controller\GetRutasPorTour;
use React\Http\Server;
use Recoil\React\ReactKernel;
use App\Rutas\Model\ModelRuta;
use App\Rutas\Controller\TestController;
use App\Rutas\Kernel\Controller\MicroGetRutas;
use App\Rutas\Kernel\Controller\MicroGetRutasPorTour;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Io\ServerRequest;
use React\MySQL\QueryResult;
use React\Socket\Server as SocketServer;

final class KernelRutas
{
    public static function kernelGetAllById($loop, $conexion, $id)
    {
        $a = ReactKernel::start(function() use ($loop, $conexion, $id) 
        {
            $modelo_rutas = new ModelRuta($conexion, $loop);
            $micro_controlador = new MicroGetRutasPorTour($modelo_rutas);
            
            $server = $micro_controlador(new ServerRequest('GET',''), $id);

            yield;
            return $server;
        });


        return $a->then(function(Array $rutas){

            return $rutas;
        });
    }

    public static function kernelGetAll($loop, $conexion)
    {
        $a = ReactKernel::start(function() use ($loop, $conexion) 
        {
            $modelo_rutas = new ModelRuta($conexion, $loop);
            $micro_controlador = new MicroGetRutas($modelo_rutas);
            $server = $micro_controlador(new ServerRequest('GET',''));

            yield;
            return $server;
        });


        return $a->then(function(Array $rutas){

            return $rutas;
        });
    }
}