<?php

namespace Backend\Ciudades\Kernel\Controllers;

use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetCiudades extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll();
    }
}