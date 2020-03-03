<?php

namespace App\Hoteles\Kernel\Controllers;

use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;

final class MicroGetHoteles extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {
        print("c");
        return $this->modelo->getAll();
    }
}