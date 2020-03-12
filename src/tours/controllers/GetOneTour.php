<?php

namespace Backend\Tours\Controllers;

use Exception;
use Backend\Tours\Tour;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Tours\Exceptions\TourNoExiste;
use Psr\Http\Message\ServerRequestInterface;

final class GetOneTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $id)
    {
        return $this->modelo->getOne($id)
            // El codigo se ejecutó satisfactoriamente
            ->then(
                function(Tour $tour)
                {
                    return RespuestaJson::OK(['tours' => $tour->toArray()]);
                }
            )
            // Se ejecutará cuando se haga un reject
            ->then(null,
                function(TourNoExiste $excepcion)
                {
                    return RespuestaJson::NOT_FOUND_DATA(['errores' => 'No se encontró el tour']);
                }
            )
            ->then(null,
                function(Exception $excepcion)
                {
                    return RespuestaJson::INTERNAL_ERROR(['errores' => $excepcion->getMessage()]);
                }
            );
    }
}