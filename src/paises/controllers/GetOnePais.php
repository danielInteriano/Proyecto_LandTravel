<?php

namespace Backend\Paises\Controllers;

use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Paises\Exceptions\PaisNoExiste;
use Backend\Paises\Pais;
use Psr\Http\Message\ServerRequestInterface;

final class GetOnePais extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function (Pais $pais) {
                    return RespuestaJson::OK(['usuarios' => $pais->toArray()]);
                }
            )->then(
                null,
                function (PaisNoExiste $error) {
                    return RespuestaJson::NOT_FOUND_DATA(['errores' => 'No se encontró el país.']);
                }
            );
    }
}
