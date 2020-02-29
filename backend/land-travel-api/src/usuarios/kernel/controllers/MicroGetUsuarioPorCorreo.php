<?php

namespace App\Usuarios\Kernel\Controllers;
use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetUsuarioPorCorreo extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $correo)
    {
        return $this->modelo->existsCorreo($correo);
    }
}