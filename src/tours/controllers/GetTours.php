<?php

namespace Backend\Tours\Controllers;

use Backend\Tours\Tour;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GetTours extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function(Array $tours)
                {
                    $data = array_map(function(Tour $tour){
                        return $tour->toArray();
                    },$tours);
                    return RespuestaJson::OK(['tours' => $data]);
                }
            );
    }
}
