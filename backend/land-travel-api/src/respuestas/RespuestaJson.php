<?php

namespace App\Respuestas;

use React\Http\Response;

final class RespuestaJson extends Response
{
    function __construct(int $code, $data = null)
    {
        $data = $data ? json_encode($data) : null;

        parent::__construct(
            $code,
            ['Content-type' => 'application/json'],
            $data
        );
    }

    public static function OK(array $data = []): self
    {
        return new self(200, $data);
    }

    public static function NOT_FOUND(): self
    {
        return new self(404, ['message' => 'No se encontro este metodo; revisa la ruta de tu petición']);
    }

    public static function NOT_FOUND_DATA($data): self
    {
        return new self(404, $data);
    }

    public static function METHOD_NOT_ALLOWED(): self
    {
        return new self(405, ['message' => 'Este metodo no está permitido']);
    }

    public static function CREATED(array $data = []): self
    {
        return new self(201, $data);
    }

    public static function ACCEPTED(): self
    {
        return new self(202);
    }

    public static function UNAUTHORIZED($data): self
    {
        return new self(401, $data);
    }

    public static function INTERNAL_ERROR($data): self
    {
        return new self(500, $data);
    }

    public static function BAD_REQUEST($data): self
    {
        return new self(400, $data);
    }
}