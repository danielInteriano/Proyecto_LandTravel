<?php

namespace Backend\Rutas\Controllers;

use Backend\Rutas\Validador;
use Backend\Rutas\Ruta;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Rutas\Exceptions\ErrorCreacionRutas;
use phpDocumentor\Reflection\Types\Array_;
use Psr\Http\Message\ServerRequestInterface;

final class GetRutas extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
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