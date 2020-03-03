<?php

namespace App\Ciudades\Controllers;

use App\Ciudades\Ciudad;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
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