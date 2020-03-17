<?php

namespace Frontend\Vistas;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Backend\Respuestas\RespuestaHtml;
use Frontend\Vistas\Interfaces\VistaInterface;

final class Comprar implements VistaInterface{
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $peticion, ... $params)
    {
        $loader = new FilesystemLoader(__DIR__.'/../templates');
        $twig = new Environment($loader);

        $variables =  [
            
        ];

        return RespuestaHtml::OK($twig->render('/comprar.html.twig', $variables));
    }
}