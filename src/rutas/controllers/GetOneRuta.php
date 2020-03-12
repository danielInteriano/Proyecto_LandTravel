<?php

namespace Backend\Rutas\Controllers;

use Exception;
use Backend\Rutas\Ruta;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;
use Backend\Rutas\Exceptions\RutaNoExiste;

final class GetOneRuta extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, $id)
    {
        return $this->modelo->getOne($id)
            // El codigo se ejecutó satisfactoriamente
            ->then(
                function (Ruta $ruta) {
                    return RespuestaJson::OK(['rutas' => $ruta->toArray()]);
                }
            )
            // Se ejecutará cuando se haga un reject
            ->then(
                null,
                function (RutaNoExiste $excepcion) {
                    return RespuestaJson::NOT_FOUND(['errores' => 'No se encontró la ruta']);
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
