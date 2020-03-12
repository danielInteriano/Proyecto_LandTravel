<?php

namespace Backend\Lugares\Kernel;

use Backend\Lugares\Kernel\Controllers\MicroGetLugares;
use Backend\Lugares\Kernel\Controllers\MicroGetLugaresPorCiudad;
use Recoil\React\ReactKernel;
use React\Http\Io\ServerRequest;
use Backend\Lugares\Model\ModelLugares;
use Backend\Nucleo\Interfaces\KernelInterface;

final class KernelLugares implements KernelInterface
{
    public static function kernelGetAllById($loop, $conexion, $id)
    {
        return ReactKernel::start(function() use ($loop, $conexion, $id) {
            $modelo_lugares = new ModelLugares($conexion, $loop);
            $micro_controlador = new MicroGetLugaresPorCiudad($modelo_lugares);
            yield;
            return $micro_controlador(new ServerRequest('GET',''), $id);
        });
    }

    public static function kernelGetAll($loop, $conexion)
    {
        return ReactKernel::start(function() use ($loop, $conexion) {
            $modelo_lugares = new ModelLugares($conexion, $loop);
            $micro_controlador = new MicroGetLugares($modelo_lugares);
            
            yield;
            return $micro_controlador(new ServerRequest('GET',''));
        });
    }

    public static function kernelGetOne($loop, $conexio, $id)
    {
    }
}