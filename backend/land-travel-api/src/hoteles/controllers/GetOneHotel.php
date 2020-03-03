<?php

namespace App\Hoteles\Controllers;

use App\Hoteles\Exceptions\HotelNoExiste;
use Exception;
use App\Hoteles\Hotel;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;

use Psr\Http\Message\ServerRequestInterface;

final class GetOneHotel extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, $id)
    {
        return $this->modelo->getOne($id)
            // El codigo se ejecutó satisfactoriamente
            ->then(
                function (Hotel $hotel) {
                    return RespuestaJson::OK(['hoteles' => $hotel->toArray()]);
                }
            )
            // Se ejecutará cuando se haga un reject
            ->then(
                null,
                function (HotelNoExiste $excepcion) {
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
