<?php

namespace Backend\Rutas\Controllers;

use Backend\Rutas\Ruta;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GetRutasPorTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $idtour)
    {
        return $this->modelo->getAllById($idtour)
            ->then(
                function(Array $rutas)
                {
                    $data = array_map(function(Ruta $ruta){
                        return $ruta->toArray();
                    },$rutas);
                    return RespuestaJson::OK(['rutas' => $data]);
                }
            );
    }
}