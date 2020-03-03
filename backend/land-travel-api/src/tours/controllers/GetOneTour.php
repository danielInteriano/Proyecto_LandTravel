<?php

namespace App\Tours\Controllers;

use Exception;
use App\Tours\Tour;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Tours\Exceptions\TourNoExiste;
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
                    return RespuestaJson::INTERNAL_ERROR(['errores' => 'No se encontró al usuario']);
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