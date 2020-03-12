<?php

namespace Backend\Paises\Controllers;

use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Paises\Pais;
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
