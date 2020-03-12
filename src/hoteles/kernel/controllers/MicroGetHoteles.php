<?php

namespace Backend\Hoteles\Kernel\Controllers;

use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetHoteles extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        return $this->modelo->getAll();
    }
}