<?php

namespace App\Tours\Controllers;

use Exception;
use App\Tours\Tour;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Tours\Exceptions\TourNoExiste;
use App\Tours\Validador;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $id)
    {
        $validador = new Validador($peticion);
        $data = $validador->validarNuevoTour();

        return $this->modelo->update($id, $data)
            ->then(
                function() use ($id) {
                    return RespuestaJson::CREATED(['mensaje' => 'El tour fue creado/actualizado', 'idtour' => $id,'creado' => true]);
                }
            )->then(null,
                function(){
                    return RespuestaJson::BAD_REQUEST(['mensaje' => 'No se pudo crear el tour', 'creado' => false]);
                }
            );
    }
}