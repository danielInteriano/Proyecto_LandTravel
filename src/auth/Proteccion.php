<?php

namespace Backend\Auth;

final class Proteccion
{
    private $llave;

    public function __construct(string $jwt)
    {
        $this->llave = $jwt;
    }

    public function proteger(callable $middlware, Array $niveles = []) : RutaProtegida
    {
        return new RutaProtegida($this->key, $middlware, $niveles);
    }
}