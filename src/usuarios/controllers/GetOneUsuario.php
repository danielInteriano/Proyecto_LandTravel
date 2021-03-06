<?php

namespace Backend\Usuarios\Controllers;

use Exception;
use Backend\Usuarios\Usuario;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;
use Backend\Usuarios\Exceptions\UsuarioNoExiste;

final class GetOneUsuario extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, $id)
    {
        return $this->modelo->getOne($id)
            // El codigo se ejecutó satisfactoriamente
            ->then(
                function (Usuario $usuario) {
                    return RespuestaJson::OK(['usuarios' => $usuario->toArray()]);
                }
            )
            // Se ejecutará cuando se haga un reject
            ->then(
                null,
                function (UsuarioNoExiste $excepcion) {
                    return RespuestaJson::NOT_FOUND(['errores' => 'No se encontró al usuario']);
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
