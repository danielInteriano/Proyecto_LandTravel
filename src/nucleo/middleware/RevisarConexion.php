<?php

namespace Backend\Nucleo\Middleware;

use Exception;
use Throwable;
use Backend\Respuestas\RespuestaJson;
use Psr\Http\Message\ServerRequestInterface;

final class RevisarConexion
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function __invoke(ServerRequestInterface $peticion, callable $siguiente)
    {
        return $this->conexion->ping()
            ->then(
                function () use ($peticion, $siguiente) 
                {
                    return $siguiente($peticion);
                })
            ->otherwise(
                function (Exception $e) {
                    return RespuestaJson::INTERNAL_ERROR(['errors' => 'Conexion: '.$e->getMessage()]);
                }
            );
    }
}