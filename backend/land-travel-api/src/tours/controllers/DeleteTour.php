<?php

namespace App\Tours\Controllers;

use Exception;
use App\Tours\Tour;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Tours\Exceptions\TourNoExiste;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $id)
    {
        return $this->modelo->delete($id)
            ->then(
                function()
                {
                    return RespuestaJson::ACCEPTED(['mensaje' => 'El tour fue eliminado', 'eliminado' => true]);
                }
            )
            ->then(null,
                function(TourNoExiste $excepcion)
                {
                    return RespuestaJson::NOT_FOUND_DATA(['errores' => 'No se encontró el tour', 'eliminado' => false]);
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