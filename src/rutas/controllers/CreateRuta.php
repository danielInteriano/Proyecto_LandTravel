<?php

namespace Backend\Rutas\Controllers;

use Backend\Rutas\Validador;
use Backend\Rutas\Ruta;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Rutas\Exceptions\ErrorCreacionRutas;
use Psr\Http\Message\ServerRequestInterface;

final class CreateRuta extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        $validador = new Validador($peticion);
        $data = $validador->validarNuevaRuta();

        return $this->modelo->create($data)
            ->then(
                function(Array $mock){
                    return RespuestaJson::CREATED(['mensaje' => 'La ruta ha sido creada', 'creado' => true]);
                }
            )->otherwise(
                function(ErrorCreacionRutas $error){
                    return RespuestaJson::BAD_REQUEST(['mensaje' => 'No se pudo crear', 'creado' => false]);
                });
    }
}