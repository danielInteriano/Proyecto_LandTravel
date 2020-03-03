<?php

namespace App\Rutas\Controller;

use App\Rutas\Validador;
use App\Rutas\Ruta;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Rutas\Exceptions\ErrorCreacionRutas;
use Psr\Http\Message\ServerRequestInterface;

final class CreateRuta extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        $validador = new Validador($peticion);
        $data = $validador->validarNuevaRuta();

        return $this->modelo->create($data)
            ->then(
                function(){
                    return RespuestaJson::CREATED(['mensaje' => 'La ruta ha sido creada', 'creado' => true]);
                }
            )->then(null,
                function(ErrorCreacionRutas $error){
                    return RespuestaJson::BAD_REQUEST(['mensaje' => 'No se pudo crear', 'creado' => false]);
                });
    }
}