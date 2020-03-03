<?php

namespace App\Hoteles\Kernel;

use App\Hoteles\Kernel\Controllers\MicroGetHoteles;
use App\Hoteles\Kernel\Controllers\MicroGetHotelesPorCiudad;
use Recoil\React\ReactKernel;
use React\Http\Io\ServerRequest;
use App\Hoteles\Model\ModelHotel;
use App\Nucleo\Interfaces\KernelInterface;


final class KernelHoteles implements KernelInterface
{
    public static function kernelGetAllById($loop, $conexion, $id)
    {
        return ReactKernel::start(function() use ($loop, $conexion, $id) {
            $modelo_hotel = new ModelHotel($conexion, $loop);
            $micro_controlador = new MicroGetHotelesPorCiudad($modelo_hotel);
            yield;
            return $micro_controlador(new ServerRequest('GET',''), $id);
        });
    }

    public static function kernelGetAll($loop, $conexion)
    {
        print("b");
        return ReactKernel::start(function() use ($loop, $conexion) {
            $modelo_hotel = new ModelHotel($conexion, $loop);
            $micro_controlador = new MicroGetHoteles($modelo_hotel);
            
            yield;
            return $micro_controlador(new ServerRequest('GET',''));
        });
    }

    public static function kernelGetOne($loop, $conexio, $id)
    {
    }
}