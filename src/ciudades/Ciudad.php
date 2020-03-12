<?php

namespace Backend\Ciudades;

final class Ciudad
{
    public $idpais;
    public $idciudad;
    public $nombre_ciudad;
    public $hoteles = [];
    public $lugares = [];

    public function __construct(string $idpais, string $idciudad, 
                                string $nombre_ciudad)
    {
        $this->idpais = $idpais;
        $this->idciudad = $idciudad;
        $this->nombre_ciudad = $nombre_ciudad;
    }

    public function toArray()
    {
        return [
            'idpais' => $this->idpais,
            'idciudad' => $this->idciudad,
            'nombre_ciudad' => $this->nombre_ciudad,
            'hoteles' => $this->hoteles,
            'lugares' => $this->lugares
        ];
    }

    public function llenarHoteles(Array $hoteles)
    {
        $this->hoteles = $hoteles;
    }

    public function llenarLugares(Array $lugares)
    {
        $this->lugares = $lugares;
    }

    public static function Ciudad(Array $data) : self
    {
        return new self($data['idpais'], $data['idciudad'], $data['nombre_ciudad']);
    }
}