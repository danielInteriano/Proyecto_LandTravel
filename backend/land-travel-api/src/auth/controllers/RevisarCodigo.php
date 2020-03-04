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