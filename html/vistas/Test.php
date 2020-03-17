<?php 

namespace Frontend\Vistas;

use Backend\Respuestas\RespuestaHtml;
use Frontend\Vistas\Interfaces\VistaInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class Test implements VistaInterface
{

    public function __invoke(ServerRequestInterface $peticion, ... $params){
        $loader = new FilesystemLoader(__DIR__.'/../templates');
        $twig = new Environment($loader);

        $variables =  [
            
        ];

        return RespuestaHtml::OK($twig->render('/base/base.html.twig', $variables));
    }
}