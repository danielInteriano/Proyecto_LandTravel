<?php

namespace Backend\Hoteles\Controllers;

use Backend\Hoteles\Hotel;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GetHoteles extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function(Array $hoteles)
                {   
                    $data = array_map(function(Hotel $hotel){
                        return $hotel->toArray();
                    },$hoteles);
                    return RespuestaJson::OK(['hoteles' => $data]);
                }
            );
    }
}