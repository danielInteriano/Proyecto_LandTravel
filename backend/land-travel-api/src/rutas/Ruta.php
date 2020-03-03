<?php

namespace App\Rutas;

final class Ruta
{
    public $idruta;
    public $idtour;
    public $idpaquete;
    public $c_dias;
    public $c_noches;
    public $co_dia;
    public $co_noche;
    public $precio;
    public $precio_hotel;
    public $precio_total;
    public $pos;
    public $lugares = [];
    public $transporte = [];

    public function __construct($idruta, $idtour, $idpaquete, $c_dias, $c_noches, 
                                $co_dia, $co_noche, $precio, $precio_hotel, $precio_total, $pos)
    {
        $this->idruta = (int) $idruta;
        $this->idtour = (int) $idtour;
        $this->idpaquete = (int) $idpaquete;
        $this->c_dias = (int) $c_dias;
        $this->c_noches = (int) $c_noches;
        $this->co_dia = (float) $co_dia;
        $this->co_noche = (float) $co_noche;
        $this->precio = (float) $precio;
        $this->precio_hotel = (float) $precio_hotel;
        $this->precio_total = (float) $precio_total;
        $this->pos = (int) $pos;
    }

    public function toArray()
    {
        return [
            'id' => $this->idruta,
            'c_dias' => $this->c_dias,
            'c_noches' => $this->c_noches,
            'co_dia' => $this->co_dia,
            'co_noche' => $this->co_noche,
            'precio' => $this->precio,
            'precio_hotel' => $this->precio_hotel,
            'precio_total' => $this->precio_total,
            'pos' => $this->pos,
            'lugares' => $this->lugares,
            'transportes' => $this->transporte
        ];
    }

    public static function Ruta(Array $data) : self
    {
        return new self($data['idruta'], $data['idtour'], $data['idpaquete'], 
                        $data['c_dias'], $data['c_noches'], $data['co_dia'], 
                        $data['co_noche'], $data['precio'],
                        $data['precio_hotel'], $data['precio_total'], $data['pos']);
    }
}