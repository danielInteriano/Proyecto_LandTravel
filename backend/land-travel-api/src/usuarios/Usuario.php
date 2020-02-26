<?php

namespace App\Usuarios;

final class Usuario
{
    public $id;
    public $nombres;
    public $apellidos;
    public $usuario;
    public $correo;
    public $pais;
    public $f_registro;

    public function __construct(string $id, string $nombres, string $apellidos, string $usuario, 
                                string $correo, string $pais, string $f_registro)
    {
        $this->id = (int) $id;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->usuario = $usuario;
        $this->correo = $correo;
        $this->pais = $pais;
        $this->f_registro = $f_registro;
    }

    public function toArray()
    {
        return [
            'usuario' => $this->usuario,
            'correo' => $this->correo
        ];
    }
}

?>