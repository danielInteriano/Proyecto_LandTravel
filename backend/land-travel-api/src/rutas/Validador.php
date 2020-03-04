<?php

namespace App\Rutas;

use Respect\Validation\Validator;
use Psr\Http\Message\ServerRequestInterface;

final class Validador
{
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function validarNuevaRuta() : Array {

        $idtour_validador = Validator::key('idtour',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::intVal()
            ))->setName('idtour');

        $idpaquete_validador = Validator::key('idpaquete',
            Validator::allOf(
                Validator::intVal()
            ))->setName('idpaquete');

        $idtransporte_validador = Validator::key('idtransporte',
            Validator::allOf(
                Validator::intVal()
            ))->setName('idtransporte');

        $idlugar_validador = Validator::key('idlugar',
            Validator::allOf(
                Validator::intVal(),
                Validator::notEmpty()
            ))->setName('idlugar');

        $idguia_validador = Validator::key('idguia',
            Validator::allOf(
                Validator::intVal(),
                Validator::notEmpty()
            ))->setName('idguia');  
        
        $c_dias_validador = Validator::key('c_dias',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::intVal()
            ))->setName('c_dias'); 

        $c_noches_validador = Validator::key('c_noches',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::intVal()
            ))->setName('c_noches'); 

        $precio_validador = Validator::key('precio',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::floatVal()
            ))->setName('precio'); 

        $validator = Validator::allOf(
            $idtour_validador, 
            $idpaquete_validador, 
            $idtransporte_validador,
            $idguia_validador,
            $idlugar_validador,
            $c_dias_validador,
            $c_noches_validador,
            $precio_validador
        );
        $validator->assert($this->request->getParsedBody());
        
        $informacion = $this->request->getParsedBody();
        return [
            'idtour' => $informacion['idtour'],
            'idpaquete' => $informacion['idpaquete'],
            'idtransporte' => $informacion['idtransporte'],
            'idlugar' => $informacion['idlugar'],
            'idguia' => $informacion['idguia'],
            'c_dias' => $informacion['c_dias'],
            'c_noches' => $informacion['c_noches'],
            'precio' => $informacion['precio']
        ];
    }
}