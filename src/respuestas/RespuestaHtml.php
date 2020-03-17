<?php

namespace Backend\Respuestas;

use React\Http\Response;

final class RespuestaHtml extends Response
{

    function __construct(int $code, $pagina = null)
    {
        parent::__construct(
            $code,
            ['Content-type' => 'text/html; charset=utf-8'],
            $pagina
        );
    }

    public static function OK($pagina) : self {
        return new self(200, $pagina);
    }

    public static function NOT_FOUND() : self {
        return new self(404);
    }
}