<?php

namespace App\Rutas\Controller;

use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use Psr\Http\Message\ServerRequestInterface;
use React\MySQL\QueryResult;
use Recoil\React\ReactKernel;

final class TestController extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion)
    {

        return $this->modelo->getAll()
            ->then(
                function(Array $rutas){
                    return new RespuestaJson(200, ['data' => 2]);
                },
            )->then(null,
                function()
                { 
                    return new RespuestaJson(200, ['data' => 3]);
                });

    }
}