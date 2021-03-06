<?php

namespace Backend\Usuarios\Kernel\Controllers;

use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetUsuarios extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll();
    }
}
