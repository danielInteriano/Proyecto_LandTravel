<?php 

namespace Backend\Auth;

use Backend\Respuestas\RespuestaJson;
use Firebase\JWT\JWT;

use Psr\Http\Message\ServerRequestInterface;

final class RutaProtegida
{   
    private $key;
    private $middleware;
    private $nivel;

    public function __construct(string $jwt, callable $middleware, Array $niveles)
    {
        $this->key = $jwt;
        $this->middleware = $middleware;
        $this->niveles = $niveles;
    }

    public function __invoke(ServerRequestInterface $peticion, ... $params)
    {
        if ($this->authorize($peticion))
        {
            return call_user_func($this->middleware, $peticion, $params[0]);
        }

        return RespuestaJson::UNAUTHORIZED();
    }

    private function authorize(ServerRequestInterface $peticion) : bool
    {
        $header = $peticion->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        if(empty($token))
        {
            return false;
        }
            
        $llave = JWT::decode($token, $this->key, ['HS256']);

        return  $llave !== null;
    }
}