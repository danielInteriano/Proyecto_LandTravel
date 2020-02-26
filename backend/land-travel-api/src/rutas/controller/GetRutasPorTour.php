<?php

namespace App\Rutas\Controller;

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
                    $data = [];
                    foreach($rutas as $ruta)
                    {
                        array_push($data, $ruta->toArray());
                    }
                    return RespuestaJson::OK(['rutas' => $data]);
                }
            );
    }
}