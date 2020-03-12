<?php

namespace Backend\Nucleo\Template;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Backend\Respuestas\RespuestaJson;
use FastRoute\Dispatcher\GroupCountBased;
use Psr\Http\Message\ServerRequestInterface;
use FastRoute\DataGenerator\GroupCountBased as DataGeneratorGroupCountBased;

class RouterTemplate
{
    private $despachador;
    private $raiz;

    public function __construct(RouteCollector $rutas, string $raiz = '')
    {
        $this->despachador = new GroupCountBased($rutas->getData());
        $this->raiz = $raiz;
    }

    public function __invoke(ServerRequestInterface $peticion)
    {
        $info_ruta = $this->despachador->dispatch(
            $peticion->getMethod(), $peticion->getUri()->getPath()
        ); 
        
        /*
            Despachador; Se encarga de la enrutacion.
            Si no encuentra el metodo, manda un NOT_FOUND;
         */ 
        switch($info_ruta[0])
        {
            case Dispatcher::NOT_FOUND:
                return RespuestaJson::NOT_FOUND();
            case Dispatcher::METHOD_NOT_ALLOWED:
                return RespuestaJson::METHOD_NOT_ALLOWED();
            case Dispatcher::FOUND:
                $params = array_values($info_ruta[2]);
                return $info_ruta[1]($peticion, ... $params);
        }

        return;
    }

    public static function factory(string $raiz) : self
    {
        $rutas = new RouteCollector(new Std(), new DataGeneratorGroupCountBased());
        return new self($rutas, $raiz);
    }
}

?>