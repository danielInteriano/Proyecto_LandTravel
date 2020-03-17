<?php

namespace Frontend\Vistas\Interfaces;

use Psr\Http\Message\ServerRequestInterface;

interface VistaInterface{

    /**
     * Se necesitan crear parametros multiples para crear la vista
     */
    public function __invoke(ServerRequestInterface $peticion, ... $params);
}