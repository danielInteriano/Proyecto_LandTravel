<?php

namespace Backend\Usuarios\Kernel;

use Recoil\React\ReactKernel;
use React\Http\Io\ServerRequest;
use Backend\Usuarios\Model\ModelUsuario;
use Backend\Nucleo\Interfaces\KernelInterface;
use Backend\Usuarios\Kernel\Controllers\MicroGetUsuarioPorCorreo;
use Backend\Usuarios\Kernel\Controllers\MicroGetUsuarios;

final class KernelUsuario implements KernelInterface
{
    public static function kernelGetAllById($loop, $conexion, $id)
    {
        return ReactKernel::start(function() use ($loop, $conexion, $id) {
            $modelo_usuario = new ModelUsuario($conexion, $loop);
            $micro_controlador = new MicroGetUsuarios($modelo_usuario); // Necesita cambiarse
            yield;
            return $micro_controlador(new ServerRequest('GET',''), $id);
        });
    }

    public static function kernelGetAll($loop, $conexion)
    {
        return ReactKernel::start(function() use ($loop, $conexion) {
            $modelo_usuario = new ModelUsuario($conexion, $loop);
            $micro_controlador = new MicroGetUsuarios($modelo_usuario);
            yield;
            return $micro_controlador(new ServerRequest('GET',''));
        });
    }

    public static function kernelGetOne($loop, $conexio, $id)
    {
    }

    public static function kernelGetByCorreo($loop, $conexion, $correo)
    {
        return ReactKernel::start(function() use ($loop, $conexion, $correo) {
            $modelo_usuario = new ModelUsuario($conexion, $loop);
            $micro_controlador = new MicroGetUsuarioPorCorreo($modelo_usuario);
            yield;
            return $micro_controlador(new ServerRequest('GET',''), $correo);
        });
    }
}