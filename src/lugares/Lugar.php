<?php

namespace Backend\Lugares;

final class Lugar
{
    public $idlugar;
    public $idciudad;
    public $nombre_lugar;

    public function __construct(string $idlugar, string $idciudad, 
                                string $nombre_lugar)
    {
        $this->idlugar = $idlugar;
        $this->idciudad = $idciudad;
        $this->nombre_lugar = $nombre_lugar;
    }

    public function toArray()
    {
        return [
            'idlugar' => $this->idlugar,
            'idciudad' => $this->idciudad,
            'nombre_lugar' => $this->nombre_lugar
        ];
    }

    public static function Lugar(Array $data) : self
    {
        return new self($data['idlugar'], $data['idciudad'], $data['nombre_lugar']);
    }
}