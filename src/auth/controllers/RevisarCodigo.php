<?php

namespace Backend\Auth\Controllers;

use Exception;
use Backend\Auth\Validador;

use Backend\Respuestas\RespuestaJson;
use Backend\Auth\Exceptions\CodigoInvalido;
use Backend\Mailer\Mailer;
use Backend\Nucleo\Template\ControladorTemplate;
use Backend\Usuarios\Exceptions\UsuarioNoExiste;
use Psr\Http\Message\ServerRequestInterface;

final class RevisarCodigo extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion){
        $validador = new Validador($peticion);
        $data = $validador->validarCodigo();

        return $this->modelo->revisarCodigo($data)
            ->then(
                function(){
                    return RespuestaJson::OK(['hecho' => true]);
                }
            )->then(null,
                function(CodigoInvalido $error){
                    return RespuestaJson::BAD_REQUEST(['hecho' => false]);
                }
            )->then(null,
                function(Exception $error){
                    return RespuestaJson::INTERNAL_ERROR(['error' => $error->getMessage()]);
                }
            );
    }
    
}