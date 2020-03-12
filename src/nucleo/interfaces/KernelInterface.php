<?php

namespace Backend\Nucleo\Interfaces;

/**
 * El kernel te permite poder hacer promesas de manera rápida.
 * Te devuelven una promesa la cual te permite el acceso a sus datos si lo haces
 * dentro de otra promesa
 */
interface KernelInterface
{
    /**
     * Te permite conseguir informacion a partir de un id
     * no propio de ese modelo por ejemplo idusuario de persona
     */
    public static function kernelGetAllById($ciclo, $conexion, $id);

    /**
     * La version kernel de GetAll
     */
    public static function kernelGetAll($ciclo, $conexion);

    /**
     * La version kernel de GetOne
     */
    public static function kernelGetOne($ciclo, $conexion, $id);
}