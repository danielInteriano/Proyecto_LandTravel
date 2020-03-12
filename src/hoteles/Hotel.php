<?php

namespace Backend\Hoteles;

final class Hotel
{
    public $idhotel;
    public $idciudad;
    public $nombre_hotel;

    public function __construct(string $idhotel, string $idciudad, 
                                string $nombre_hotel)
    {
        $this->idhotel = $idhotel;
        $this->idciudad = $idciudad;
        $this->nombre_hotel = $nombre_hotel;
    }

    public function toArray()
    {
        return [
            'idhotel' => $this->idhotel,
            'idciudad' => $this->idciudad,
            'nombre_hotel' => $this->nombre_hotel
        ];
    }

    public static function Hotel(Array $data) : self
    {
        return new self($data['idhotel'], $data['idciudad'], $data['nombre_hotel']);
    }
}