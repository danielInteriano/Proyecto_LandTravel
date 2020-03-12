<?php

namespace Backend\Usuarios;

final class Usuario
{
    public $idusuario;
    public $nombres;
    public $apellidos;
    public $contraseña;
    public $usuario;
    public $correo;
    public $pais;
    public $f_registro;
    public $nivel;

    public function __construct(string $id = '', string $nombres = '', string $apellidos = '', string $usuario = '', 
                                string $contraseña = '', string $correo = '', string $pais = '', string $f_registro = '')
    {
        $this->idusuario = (int) $id;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->correo = $correo;
        $this->pais = $pais;
        $this->f_registro = $f_registro;
    }

    public function toArray()
    {
        return [
            'id' => $this->idusuario,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'usuario' => $this->usuario,
            'correo' => $this->correo,
            'f_registro' => $this->f_registro
        ];
    }

    public static function Usuario(Array $data) : self
    {
        $idusuario = $data['idusuario'];
        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];
        $usuario = $data['usuario'];
        $contraseña = $data['contraseña'];
        $correo = $data['correo'];
        $pais = $data['pais'];
        $f_registro = $data['f_registro'];
        return new self($idusuario, $nombres, $apellidos, $usuario, $contraseña, $correo, $pais, $f_registro);
    }
}

?>