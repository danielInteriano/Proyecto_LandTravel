<?php

namespace Backend\Usuarios\Controllers;

use Backend\Usuarios\Usuario;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GetUsuarios extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function(Array $usuarios)
                {
                    $data = array_map(function(Usuario $usuario){
                        return $usuario->toArray();
                    },$usuarios);
                    return RespuestaJson::OK(['usuarios' => $data]);
                }
            );
    }
}
