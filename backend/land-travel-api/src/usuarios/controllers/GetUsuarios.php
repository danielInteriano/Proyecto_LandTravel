<?php

namespace App\Usuarios\Controllers;

use App\Nucleo\Template\ControladorTemplate;
use App\Respuestas\RespuestaJson;
use App\Usuarios\Model\ModelUsuario;
use App\Usuarios\Usuario;
use Psr\Http\Message\ServerRequestInterface;

final class GetUsuarios extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll()
            ->then(
                function(Array $usuarios)
                {
                    $data = [];
                    foreach($usuarios as $usuario)
                    {
                        array_push($data, $usuario->toArray());
                    }
                    return RespuestaJson::OK(['usuarios' => $data]);
                }
            );
    }

    public static function factory($conexion) : self
    {
        $modelo = new ModelUsuario($conexion);
        return new self($modelo);
    }
}
