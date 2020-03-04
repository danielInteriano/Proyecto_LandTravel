<?php

namespace App\Paises\Controllers;

use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Paises\Exceptions\PaisNoExiste;
use App\Paises\Pais;
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
