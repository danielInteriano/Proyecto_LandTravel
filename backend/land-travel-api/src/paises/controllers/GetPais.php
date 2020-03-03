<?php

namespace App\Paises\Controllers;

use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Paises\Pais;
use Psr\Http\Message\ServerRequestInterface;

final class GetPais extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function (array $paises) {
                    $data = array_map(function (Pais $pais) {
                        return $pais->toArray();
                    }, $paises);
                    return RespuestaJson::OK(['paises' => $data]);
                }
            );
    }
}
