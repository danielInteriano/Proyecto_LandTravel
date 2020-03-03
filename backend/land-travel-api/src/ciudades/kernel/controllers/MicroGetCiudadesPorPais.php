<?php

namespace App\Ciudades\Kernel\Controllers;

use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetCiuadesPorPais extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $idpais)
    {
        return $this->modelo->getAllById($idciudad);
    }
}