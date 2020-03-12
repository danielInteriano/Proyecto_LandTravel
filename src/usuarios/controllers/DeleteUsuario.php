<?php

namespace Backend\Usuarios\Controllers;

use Exception;
use Backend\Usuarios\Usuario;
use Backend\Respuestas\RespuestaJson;
use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;
use Backend\Usuarios\Exceptions\UsuarioNoExiste;

final class DeleteUsuario extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, $id)
    {
        
        return $this->modelo->delete($id)
            // El codigo se ejecutó satisfactoriamente
            ->then(
                function()
                {
                    return RespuestaJson::ACCEPTED(['mensaje' => 'El usuario fue eliminado']);
                }
            )
            // Se ejecutará cuando se haga un reject
            ->then(null,
                function(UsuarioNoExiste $excepcion)
                {
                    return RespuestaJson::NOT_FOUND_DATA(['errores' => 'No se encontró al usuario']);
                }
            )
            ->then(null,
                function(Exception $excepcion)
                {
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
