<?php

namespace App\Tours\Controllers;

use App\Nucleo\Template\ControladorTemplate;
use App\Respuestas\RespuestaJson;
use App\Rutas\Model\ModelRuta;
use App\Tours\Model\ModelTours;
use Psr\Http\Message\ServerRequestInterface;

final class GetTours extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function(Array $tours)
                {
                    $data = [];
                    foreach($tours as $tour)
                    {
                        array_push($data, $tour->toArray());
                    }
                    return RespuestaJson::OK(['tours' => $data]);
                }
            );
    }

    public static function factory($conexion) : self
    {
        $modelo = new ModelTours($conexion);
        return new self($modelo);
    }
}
