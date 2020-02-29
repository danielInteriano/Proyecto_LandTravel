<?php

namespace App\Usuarios\Controllers;

use App\Usuarios\Usuario;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
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
