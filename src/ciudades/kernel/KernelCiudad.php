<?php

namespace Backend\Ciudades\Kernel;

use Backend\Ciudades\Kernel\Controllers\MicroGetCiuadesPorPais;
use Backend\Ciudades\Kernel\Controllers\MicroGetCiudades;
use Backend\Ciudades\Model\ModelCiudad;
use Recoil\React\ReactKernel;
use React\Http\Io\ServerRequest;

use Backend\Nucleo\Interfaces\KernelInterface;

final class KernelCiudad implements KernelInterface
{
    public static function kernelGetAllById($loop, $conexion, $id)
    {
        return ReactKernel::start(function() use ($loop, $conexion, $id) {
            $modelo_ciudades = new ModelCiudad($conexion, $loop);
            $micro_controlador = new MicroGetCiuadesPorPais($modelo_ciudades);
            yield;
            return $micro_controlador(new ServerRequest('GET',''), $id);
        });
    }

    public static function kernelGetAll($loop, $conexion)
    {
        return ReactKernel::start(function() use ($loop, $conexion) {
            $modelo_ciudades = new ModelCiudad($conexion, $loop);
            $micro_controlador = new MicroGetCiudades($modelo_ciudades);
            
            yield;
            return $micro_controlador(new ServerRequest('GET',''));
        });
    }

    public static function kernelGetOne($loop, $conexio, $id)
    {
    }
}