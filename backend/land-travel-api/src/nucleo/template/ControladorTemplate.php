<?php

namespace App\Nucleo\Template;

use App\Nucleo\Interfaces\ModelInterface;

class ControladorTemplate
{
    protected $entrada;
    protected $modelo;
    protected $salida;

    function __construct(ModelInterface $modelo)
    {
        $this->modelo = $modelo;
    }

}

?>