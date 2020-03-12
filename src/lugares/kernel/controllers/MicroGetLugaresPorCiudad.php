<?php

namespace Backend\Lugares\Kernel\Controllers;

use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetLugaresPorCiudad extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $idciudad)
    {
        return $this->modelo->getAllById($idciudad);
    }
}