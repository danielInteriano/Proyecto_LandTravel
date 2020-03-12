<?php

namespace Backend\Tours\Controllers;

use Exception;
use Backend\Tours\Tour;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Tours\Exceptions\TourNoExiste;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $id)
    {
        return $this->modelo->delete($id)
            ->then(
                function()
                {
                    return RespuestaJson::ACCEPTED(['mensaje' => 'El tour fue eliminado', 'hecho' => true]);
                }
            )
            ->then(null,
                function(TourNoExiste $excepcion)
                {
                    return RespuestaJson::NOT_FOUND_DATA(['errores' => 'No se encontró el tour', 'hecho' => false]);
                }
            )
            ->then(null,
                function(Exception $excepcion)
                {
                    return RespuestaJson::INTERNAL_ERROR(['errores' => $excepcion->getMessage()]);
                }
            );;
    }
}