<?php

namespace Backend\Ciudades\Controllers;

use Backend\Ciudades\Ciudad;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GetCiudades extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function(Array $ciudades)
                {   
                    $data = array_map(function(Ciudad $ciudad){
                        return $ciudad->toArray();
                    },$ciudades);
                    return RespuestaJson::OK(['ciudades' => $data]);
                }
            );
    }
}