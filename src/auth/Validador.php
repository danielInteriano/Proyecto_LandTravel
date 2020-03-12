<?php

namespace Backend\Auth;

use Respect\Validation\Validator;
use Psr\Http\Message\ServerRequestInterface;

final class Validador
{
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function validarNuevoUsuario() : Array {

        $p_nombre_validador = Validator::key('p_nombre',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::noWhitespace(),
                Validator::stringType()
            ))->setName('p_nombre');
        
        $s_nombre_validador = Validator::key('s_nombre',
            Validator::allOf(
                Validator::noWhitespace(),
                Validator::stringType()
            ))->setName('s_nombre');

        $p_apellido_validador = Validator::key('p_apellido',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::noWhitespace(),
                Validator::stringType()
            ))->setName('p_apellido'); 

        $s_apellido_validador = Validator::key('s_apellido',
            Validator::allOf(
                Validator::noWhitespace(),
                Validator::stringType()
            ))->setName('s_apellido'); 
    
        $correo_validador = Validator::key('correo', 
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType(),
                Validator::email()
            ))->setName('correo');
        
        $contraseña_validador = Validator::key('contraseña',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('contraseña');
        
        $f_nacimiento_validador = Validator::key('f_nacimiento',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::date()
            ))->setName('f_nacimiento');
    
        $identidad_validador = Validator::key('identidad',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('identidad');

        $idpais_validador = Validator::key('idpais',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::intVal()
            ))->setName('idpais');
        
        $validator = Validator::allOf(
            $p_nombre_validador, 
            $s_nombre_validador, 
            $p_apellido_validador,
            $s_apellido_validador,
            $correo_validador,
            $f_nacimiento_validador,
            $identidad_validador,
            $contraseña_validador,
            $idpais_validador
        );
        $validator->assert($this->request->getParsedBody());
        
        $informacion = $this->request->getParsedBody();
        return [
            'p_nombre' => $informacion['p_nombre'],
            's_nombre' => $informacion['s_nombre'],
            'p_apellido' => $informacion['p_apellido'],
            's_apellido' => $informacion['s_apellido'],
            'correo' => $informacion['correo'],
            'contraseña' => password_hash($informacion['contraseña'], PASSWORD_DEFAULT),
            'contraseña_sin_hash' => $informacion['contraseña'],
            'f_nacimiento' => date('Y-m-d', strtotime($informacion['f_nacimiento'])),
            'identidad' => $informacion['identidad'],
            'idpais' => $informacion['idpais']
        ];
    }

    public function validarLogin()
    {
        $usuario_validador = Validator::key('usuario', 
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('usuario');
        
        $contraseña_validador = Validator::key('contraseña',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('contraseña');

        $validator = Validator::allOf(
            $usuario_validador, 
            $contraseña_validador
        );
        $validator->assert($this->request->getParsedBody());

        $informacion = $this->request->getParsedBody();
        return [
            'usuario' => $informacion['usuario'],
            'contraseña' => $informacion['contraseña']
        ];
    }

    public function validarCorreo()
    {
        $correo_validador = Validator::key('correo', 
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('correo');
        
        $validator = Validator::allOf(
            $correo_validador
        );
        $validator->assert($this->request->getParsedBody());

        $informacion = $this->request->getParsedBody();
        return [
            'correo' => $informacion['correo']
        ];
    }

    public function validarRestablecerContraseña()
    {
        $correo_validador = Validator::key('correo', 
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('correo');

        $contraseña_validador = Validator::key('nueva_contraseña',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('nueva_contraseña');
        
        $codigo_validador = Validator::key('codigo',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('codigo');
        
        $validator = Validator::allOf(
            $correo_validador,
            $contraseña_validador,
            $codigo_validador
        );
        $validator->assert($this->request->getParsedBody());

        $informacion = $this->request->getParsedBody();
        return [
            'correo' => $informacion['correo'],
            'nueva_contraseña' => $informacion['nueva_contraseña'],
            'codigo' => $informacion['codigo']
        ];
    }

    public function validarCodigo()
    {        
        $codigo_validador = Validator::key('codigo',
            Validator::allOf(
                Validator::notEmpty(),
                Validator::stringType()
            ))->setName('codigo');
        
        $validator = Validator::allOf(
            $codigo_validador
        );
        $validator->assert($this->request->getParsedBody());

        $informacion = $this->request->getParsedBody();
        return [
            'codigo' => $informacion['codigo']
        ];
    }
    
}