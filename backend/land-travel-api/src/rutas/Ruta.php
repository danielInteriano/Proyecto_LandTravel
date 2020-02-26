<?php

namespace App\Rutas;

final class Ruta
{
    public $idruta;
    public $idtour;
    public $paquete;
    public $c_dias;
    public $c_noches;
    public $precio;
    public $pos;

    public function __construct($idruta, $idtour, $paquete, $c_dias, $c_noches, $precio, $pos)
    {
        $this->idruta = (int) $idruta;
        $this->idtour = (int) $idtour;
        $this->paquete = $paquete;
        $this->c_dias = (int) $c_dias;
        $this->c_noches = (int) $c_noches;
        $this->precio = (float) $precio;
        $this->pos = (int) $pos;
    }

    public function toArray()
    {
        return [
            'id' => $this->idruta,
            'c_dias' => $this->c_dias,
            'c_noches' => $this->c_noches,
            'precio' => $this->precio,
            'pos' => $this->pos,
        ];
    }
}