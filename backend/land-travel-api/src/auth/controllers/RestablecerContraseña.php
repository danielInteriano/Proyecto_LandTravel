<?php

namespace App\Auth\Controllers;

use Exception;
use App\Auth\Validador;

use App\Respuestas\RespuestaJson;
use App\Auth\Exceptions\CodigoInvalido;
use App\Mailer\Mailer;
use App\Nucleo\Template\ControladorTemplate;
use App\Usuarios\Exceptions\UsuarioNoExiste;
use Psr\Http\Message\ServerRequestInterface;

final class RestablecerContraseña extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion){
        $validador = new Validador($peticion);
        $data = $validador->validarRestablecerContraseña();

        return $this->modelo->restablecerContraseña($data)
            ->then(
                function(Array $nueva_data){
                    Mailer::emailConfirmacion($nueva_data['correo'], $nueva_data['usuario'], $nueva_data['nueva_contraseña']);
                    return RespuestaJson::OK(['mensaje' => 'Se restablecio la contraseña', 'hecho' => true]);
                }
            )->then(null,
                function(CodigoInvalido $error){
                    return RespuestaJson::BAD_REQUEST(['error' => 'El codigo es incorrecto', 'hecho' => false]);
                }
            )->then(null,
                function(Exception $error){
                    return RespuestaJson::INTERNAL_ERROR(['error' => $error->getMessage()]);
                }
            );
    }
    
}