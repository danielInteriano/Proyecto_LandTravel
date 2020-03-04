<?php

namespace App\Auth\Controllers;

use Firebase\JWT\JWT;
use App\Auth\Validador;
use App\Nucleo\Interfaces\ModelInterface;
use App\Usuarios\Usuario;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Usuarios\Exceptions\UsuarioNoExiste;
use Psr\Http\Message\ServerRequestInterface;

final class IniciarSesion extends ControladorTemplate
{
    private $jwt;

    public function __construct(ModelInterface $modelo, string $jwt)
    {
        parent::__construct($modelo);
        $this->jwt = $jwt;
    }

    public function __invoke(ServerRequestInterface $peticion)
    {
        $validador = new Validador($peticion);
        $data = $validador->validarLogin();

        return $this->modelo->iniciarSesion($data)
            ->then(function(Usuario $usuario) use ($data)
            {  
                if(password_verify($data['contraseña'], $usuario->contraseña))
                {
                    $payload = [
                        'id' => $usuario->idusuario,
                        'usuario' => $usuario->usuario,
                        'exp' => time() + 60*60
                    ];
                    $token = JWT::encode($payload, $this->jwt);
                    return RespuestaJson::OK(['token' => $token, 'logged' => true]);
                }

                return RespuestaJson::UNAUTHORIZED(['error' => 'Contraseña o correo incorrecto', 'logged' => false]);
            }
            )->then(null,
                function(UsuarioNoExiste $error)
                {
                    return RespuestaJson::UNAUTHORIZED(['error' => 'Credenciales incorrecots', 'logged' => false]);
                }
            );
    }
}