<?php

namespace Backend\Nucleo\Controllers;

use Backend\Respuestas\RespuestaArchivo;
use Backend\Respuestas\RespuestaJson;
use finfo;
use Psr\Http\Message\ServerRequestInterface;

final class GetRecurso {
    private $root;

    public final function __construct(string $root)
    {
        $this->root = $root;
    }
    
    public final function __invoke(ServerRequestInterface $peticion, ... $params)
    {
        $path = $this->root.$peticion->getUri()->getPath();
        if (file_exists($path)){
            $handler = fopen($path, 'r');
            $file = fread($handler, filesize($path));
            fclose($handler);
            $resultados = [];

            preg_match('/^([a-zA-Z0-9\s_\\.\-\(\):])+\.(.*)$/', end($params), $resultados);
            
            return RespuestaArchivo::OK($file, $resultados[2]);
        }

        return RespuestaJson::NOT_FOUND();
    }
}