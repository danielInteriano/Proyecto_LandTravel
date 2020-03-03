<?php

namespace App\Lugares\Controllers;

use App\Lugares\Lugar;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
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