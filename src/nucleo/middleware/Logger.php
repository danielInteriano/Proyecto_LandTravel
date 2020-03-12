<?php

namespace Backend\Nucleo\Middleware;

use Psr\Http\Message\ServerRequestInterface;

final class Logger
{
    public function __invoke(ServerRequestInterface $peticion, callable $siguiente)
    {
        return $siguiente($peticion);
    }
}