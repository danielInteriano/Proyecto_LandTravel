<?php

namespace App\Hoteles\Kernel\Controllers;

use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetHotelesPorCiudad extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $idciudad)
    {
        return $this->modelo->getAllById($idciudad);
    }
}