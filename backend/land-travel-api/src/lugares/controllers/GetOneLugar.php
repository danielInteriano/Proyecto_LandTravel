<?php

namespace App\Lugares\Controllers;

use Exception;
use App\Lugares\Lugar;
use App\Respuestas\RespuestaJson;
use App\Lugares\Exceptions\LugarNoExiste;
use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class GetOneLugar extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, $id)
    {
        return $this->modelo->getOne($id)
            // El codigo se ejecutó satisfactoriamente
            ->then(
                function (Lugar $lugar) {
                    return RespuestaJson::OK(['lugares' => $lugar->toArray()]);
                }
            )
            // Se ejecutará cuando se haga un reject
            ->then(
                null,
                function (LugarNoExiste $excepcion) {
                    return RespuestaJson::NOT_FOUND(['errores' => 'No se encontró el hotel']);
                }
            )
            ->then(
                null,
                function (Exception $excepcion) {
                    return RespuestaJson::INTERNAL_ERROR(['errores' => $excepcion->getMessage()]);
                }
            );
    }
    /*
    public static function factory($conexion) : self
    {
        $modelo = new ModelUsuario($conexion);
        return new self($modelo);
    }
*/
}
