<?php

namespace App\Tours;

final class Tour
{
    public $idtour;
    public $descripcion;
    public $nombre_tour;
    public $cupo;
    public $rutas = [];
    public $guias = [];

    public function __construct(string $id, string $descripcion, string $nombre_tour, $cupo)
    {
        $this->idtour = (int) $id;
        $this->descripcion = $descripcion;
        $this->nombre_tour = $nombre_tour;
        $this->cupo = (int) $cupo;
    }

    public function llenarRutas(Array $rutas)
    {
        $this->rutas = $rutas;
    }

    public function llenarGuias(Array $rutas)
    {
        $this->rutas = $rutas;
    }

    public function toArray()
    {
        return [
            'id' => $this->idtour,
            'descripcion' => $this->descripcion,
            'nombre' => $this->nombre_tour,
            'cupo' => $this->cupo,
            'rutas' => $this->rutas,
            'guias' => $this->guias
        ];
    }
}