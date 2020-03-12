<?php

namespace Backend\Tours;

use Respect\Validation\Validator;
use Psr\Http\Message\ServerRequestInterface;

final class Validador
{
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function validarNuevoTour() : Array {

        $idtipo_validador = Validator::key('idtipo_tour',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::intVal()
            ))->setName('idtipo_tour');
        
        $nombre_validador = Validator::key('nombre',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('nombre');

        $fecha_validador = Validator::key('fecha_inicio',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::date()
            ))->setName('fecha_inicio');

        $cupo_validador = Validator::key('cupo',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::intVal()
            ))->setName('cupo');
        
        $validator = Validator::allOf(
            $idtipo_validador,
            $nombre_validador,
            $fecha_validador,
            $cupo_validador
        );
        $validator->assert($this->request->getParsedBody());
        
        $informacion = $this->request->getParsedBody();
        return [
            'idtipo_tour' => $informacion['idtipo_tour'],
            'nombre' => $informacion['nombre'],
            'fecha_inicio' => date('Y-m-d', strtotime($informacion['fecha_inicio'])),
            'cupo' => $informacion['cupo']
        ];
    }

}