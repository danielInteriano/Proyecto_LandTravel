<?php

namespace App\Tours;

final class Tour
{
    public $idtour;
    public $tipo;
    public $nombre_tour;
    public $cupo;
    public $fecha_inicio;
    public $precio_total;
    public $rutas = [];
    public $guias = [];

    public function __construct(string $id, string $descripcion, string $nombre_tour, 
                                string $cupo, string $fecha_inicio, string $precio)
    {
        $this->idtour = (int) $id;
        $this->tipo = $descripcion;
        $this->nombre_tour = $nombre_tour;
        $this->cupo = (int) $cupo;
        $this->fecha_inicio = $fecha_inicio;
        $this->precio_total = (float) $precio;
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
            'tipo' => $this->tipo,
            'nombre' => $this->nombre_tour,
            'cupo' => $this->cupo,
            'fecha_inicio' => $this->fecha_inicio,
            'precio_total' => $this->precio_total,
            'rutas' => $this->rutas,
            'guias' => $this->guias
        ];
    }

    public static function Tour(Array $data) : self
    {
        return new self($data['idtour'], $data['tipo'], $data['nombre_tour'], 
                        $data['cupo'], $data['fecha_inicio'], $data['precio_total']);
    }
}