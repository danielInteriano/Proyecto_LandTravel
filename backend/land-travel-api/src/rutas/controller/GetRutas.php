<?php

namespace App\Rutas\Controller;

use App\Rutas\Validador;
use App\Rutas\Ruta;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Rutas\Exceptions\ErrorCreacionRutas;
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