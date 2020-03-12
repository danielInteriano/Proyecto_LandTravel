<?php 

namespace Frontend;

use Backend\Respuestas\RespuestaHtml;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class Test
{

    public function __invoke(ServerRequestInterface $peticion){
        $loader = new FilesystemLoader('html/templates');
        $twig = new Environment($loader);

        return RespuestaHtml::OK($twig->render('content.html.twig'));
    }
}