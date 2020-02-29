<?php

namespace App\Rutas\Controller;

use App\Rutas\Ruta;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
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