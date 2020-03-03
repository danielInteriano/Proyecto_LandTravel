<?php

namespace App\Ciudades\Kernel;

use App\Ciudades\Kernel\Controllers\MicroGetCiuadesPorPais;
use App\Ciudades\Kernel\Controllers\MicroGetCiudades;
use App\Ciudades\Model\ModelCiudad;
use Recoil\React\ReactKernel;
use React\Http\Io\ServerRequest;

use App\Nucleo\Interfaces\KernelInterface;

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