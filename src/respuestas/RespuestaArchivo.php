<?php

namespace Backend\Respuestas;

use React\Http\Response;

final class RespuestaArchivo extends Response
{

    function __construct(int $code, $recurso = null, $extension)
    {
        $headers = [];
        switch($extension){
            case 'css':
                $headers['Content-Type'] = 'text/css; charset=utf-8';
                break;
            case 'js':
                $headers['Content-Type'] = 'application/x-javascript; charset=utf-8';
                break;
            case 'png':
                $headers['Content-Type'] = 'image/png; charset=utf-8';
                break;
            case 'jpg':
                $headers['Content-Type'] = 'image/jpg; charset=utf-8';
                break;
        }
        parent::__construct(
            $code,
            $headers,
            $recurso
        );
    }

    public static function OK($recurso, $extension) : self {
        return new self(200, $recurso, $extension);
    }

}