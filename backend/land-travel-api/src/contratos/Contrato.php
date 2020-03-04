<?php

namespace App\Contratos;

final class Contrato
{
    public $idcontrato;
    public $idtipo_contrato;
    public $cantidad_horas;
    public $imagen_contrato;
    public $tipo_contrato;
    public $vacaciones_mensuales;
    public $fecha_firmado;
    public $siguiente_firma;
    public $autorenovado;
    public $cargos = [];

    public function __construct(string $idcontrato, string $idtipo_contrato, string $cantidad_horas, 
                                string $imagen_contrato, string $tipo_contrato, string $vacaciones_mensuales, 
                                string $fecha_firmado, string $siguiente_firma, bool $autorenovado)
    {
        $this->idcontrato = (int) $idcontrato;
        $this->idtipo_contrato = (int) $idtipo_contrato;
        $this->cantidad_horas = (int) $cantidad_horas;
        $this->imagen_contrato = $imagen_contrato;
        $this->tipo_contrato = $tipo_contrato;
        $this->vacaciones_mensuales = (int) $vacaciones_mensuales;
        $this->fecha_firmado = $fecha_firmado;
        $this->siguiente_firma = $siguiente_firma;
        $this->autorenovado = $autorenovado;
    }

    public function toArray()
    {
        return [
            'id' => $this->idcontrato,
            'tipo_contrato' => $this->tipo_contrato,
            'cantidad_horas' => $this->cantidad_horas,
            'vacaciones_mensuales' => $this->vacaciones_mensuales,
            'fecha_firmado' => $this->fecha_firmado,
            'siguiente_firma' => $this->siguiente_firma,
            'imagen_contrato' => $this->imagen_contrato,
            'fecha_firmado' => $this->fecha_firmado,
            'siguiente_firma' => $this->siguiente_firma,
            'cargos' => $this->cargos
        ];
    }

    public static function Contrato(Array $data) : self
    {
        return new self($data['idcontrato'], $data['idtipo_contrato'], $data['cantidad_horas'], 
                        $data['imagen_contrato'], $data['tipo_contrato'], $data['c_vacaciones_m'], 
                        $data['f_firmado'], $data['s_firmado'], $data['autorenovado']);
    }
}