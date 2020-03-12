<?php

namespace Backend\Rutas\Kernel\Controller;

use Backend\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetRutasPorTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $idtour)
    {
        return $this->modelo->getAllById($idtour);
    }
}