<?php

namespace App\Auth\Controllers;

use Exception;

use App\Mailer\Mailer;
use App\Auth\Validador;
use App\Usuarios\Usuario;
use App\Respuestas\RespuestaJson;
use App\Auth\Exceptions\CorreoNoDisponible;
use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;
use App\Auth\Exceptions\IdentidadNoDisponible;

final class Registrarse extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion){
        $validador = new Validador($peticion);
        $data = $validador->validarNuevoUsuario();

        return $this->modelo->create($data)
            ->then(
                function(Usuario $usuario)
                {
                    Mailer::emailConfirmacion($usuario->correo, $usuario->usuario, $usuario->contraseña);
                    return RespuestaJson::CREATED(['mensaje' => 'Creado con exito', 'creado' => true]);
                }
            )->then(null,
                function(CorreoNoDisponible $error){
                    return RespuestaJson::BAD_REQUEST(['error' => 'El correo ya existe', 'creado' => false]);
                }
            )->then(null,
                function(){
                    return RespuestaJson::BAD_REQUEST(['error' => 'Esa identidad ya existe', 'creado' => false]);
                }
            )->then(null,
                function(Exception $error){
                    return RespuestaJson::INTERNAL_ERROR(['error' => $error->getMessage()]);
                }
            );
    }
    
}