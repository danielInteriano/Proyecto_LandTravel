<?php

namespace App\Auth\Controllers;

use App\Auth\Exceptions\CodigoInvalido;
use Exception;

use App\Mailer\Mailer;
use App\Auth\Validador;
use App\Usuarios\Usuario;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GenerarCodigoRespaldo extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion){
        $validador = new Validador($peticion);
        $data = $validador->validarCorreo();

        return $this->modelo->generarCodigoRespaldo($data['correo'])
            ->then(
                function(string $codigo) use ($data) {
                    Mailer::emailContraseñaPerdida($data['correo'], $codigo);
                    return RespuestaJson::CREATED(['mensaje' => 'Codigo enviado al correo', 'creado' => true]);
                }
            )->then(null,
                function(CodigoInvalido $error){
                    return RespuestaJson::BAD_REQUEST(['error' => 'Hubo un error al momento de crear el codigo', 'creado' => false]);
                }
            )->then(null,
                function(){
                    return RespuestaJson::BAD_REQUEST(['error' => 'No existe el usuario', 'creado' => false]);
                }
            )->then(null,
                function(Exception $error){
                    return RespuestaJson::INTERNAL_ERROR(['error' => $error->getMessage()]);
                }
            );
    }
    
}