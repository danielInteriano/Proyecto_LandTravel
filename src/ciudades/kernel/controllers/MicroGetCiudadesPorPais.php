<?php

namespace Backend\Ciudades\Kernel\Controllers;

use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetCiuadesPorPais extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $idpais)
    {
        return $this->modelo->getAllById($idpais);
    }
}