<?php

namespace App\Rutas\Kernel;

use Recoil\React\ReactKernel;
use App\Rutas\Model\ModelRuta;
use React\Http\Io\ServerRequest;
use App\Nucleo\Interfaces\KernelInterface;
use App\Rutas\Kernel\Controller\MicroGetRutas;
use App\Rutas\Kernel\Controller\MicroGetRutasPorTour;

final class KernelRutas implements KernelInterface
{
    public static function kernelGetAllById($loop, $conexion, $id)
    {
        return ReactKernel::start(function() use ($loop, $conexion, $id) {
            $modelo_rutas = new ModelRuta($conexion, $loop);
            $micro_controlador = new MicroGetRutasPorTour($modelo_rutas);
            yield;
            return $micro_controlador(new ServerRequest('GET',''), $id);
        });
    }

    public static function kernelGetAll($loop, $conexion)
    {
        return ReactKernel::start(function() use ($loop, $conexion) {
            $modelo_rutas = new ModelRuta($conexion, $loop);
            $micro_controlador = new MicroGetRutas($modelo_rutas);
            yield;
            return $micro_controlador(new ServerRequest('GET',''));
        });
    }

    public static function kernelGetOne($loop, $conexio, $id)
    {
    }
}