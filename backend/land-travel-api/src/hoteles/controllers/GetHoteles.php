<?php

namespace App\Hoteles\Controllers;

use App\Hoteles\Hotel;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
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