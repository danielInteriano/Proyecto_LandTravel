<?php

namespace App\Paises;

final class Pais
{
    public $idpais;
    public $nombre;
    public $nacionalidad;
    public $est_telefono;
    public $est_identidad;
    public $ciudades = [];

    public function __construct(string $idpais, string $nombre, string $nacionalidad, 
                                string $est_telefono, string $est_identidad)
    {
        $this->idpais = $idpais;
        $this->nombre = $nombre;
        $this->nacionalidad = $nacionalidad;
        $this->est_telefono = $est_telefono;
        $this->est_identidad = $est_identidad;
    }

    public function toArray()
    {
        return [
            'idpais' => $this->idpais,
            'nombre' => $this->nombre,
            'nacionalidad' => $this->nacionalidad,
            'estandar_telefono' => $this->est_telefono,
            'estandar_identidad' => $this->est_identidad,
            'ciudades' => $this->ciudades
        ];
    }

    public function llenarCiudades(Array $ciudades)
    {
        $this->ciudades = $ciudades;
    }

    public static function Pais(Array $data) : self
    {
        return new self($data['idpais'], $data['nombre'], $data['nacionalidad'], 
                        $data['est_telefono'], $data['est_identidad']);
    }
}