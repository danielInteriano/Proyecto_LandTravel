<?php

namespace App\Tours\Controllers;

use Exception;
use App\Tours\Tour;
use App\Respuestas\RespuestaJson;
use App\Nucleo\Template\ControladorTemplate;
use App\Tours\Exceptions\TourNoExiste;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateTour extends ControladorTemplate
{
    public function __invoke(ServerRequestInterface $peticion, string $id)
    {
        return $this->modelo->update($id);
    }
}