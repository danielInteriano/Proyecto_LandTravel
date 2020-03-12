<?php

namespace Backend\Lugares\Controllers;

use Backend\Lugares\Lugar;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GetLugares extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function(Array $lugares)
                {   
                    $data = array_map(function(Lugar $lugar){
                        return $lugar->toArray();
                    },$lugares);
                    return RespuestaJson::OK(['lugares' => $data]);
                }
            );
    }
}