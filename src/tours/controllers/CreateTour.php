<?php

namespace Backend\Tours\Controllers;

use Exception;
use Backend\Tours\Tour;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Tours\Validador;
use Psr\Http\Message\ServerRequestInterface;

final class CreateTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        $validador = new Validador($peticion);
        $data = $validador->validarNuevoTour();

        return $this->modelo->create($data)
            ->then(
                function(String $id) use ($data) {
                    return RespuestaJson::CREATED(['mensaje' => 'El tour fue creado', 'idtour' => $id,'creado' => true]);
                }
            )->then(null,
                function(){
                    return RespuestaJson::BAD_REQUEST(['mensaje' => 'No se pudo crear el tour', 'creado' => false]);
                }
            );
    }
}