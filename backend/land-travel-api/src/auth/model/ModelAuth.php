<?php

namespace App\Auth\Model;

use App\Auth\Exceptions\CodigoInvalido;
use App\Usuarios\Usuario;
use React\MySQL\QueryResult;
use function React\Promise\reject;
use React\EventLoop\LoopInterface;
use function React\Promise\resolve;

use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use App\Usuarios\Kernel\KernelUsuario;
use App\Auth\Exceptions\CorreoNoExiste;
use App\Nucleo\Interfaces\ModelInterface;
use App\Auth\Exceptions\CorreoNoDisponible;
use App\Usuarios\Exceptions\UsuarioNoExiste;
use App\Auth\Exceptions\IdentidadNoDisponible;

final class ModelAuth implements ModelInterface
{

    protected $conexion;
    protected $ciclo;

    public function __construct(ConnectionInterface $conexion, LoopInterface $ciclo)
    {
        $this->conexion = $conexion;
        $this->ciclo = $ciclo;
    }
    
    public function getAll() : PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function getOne(string $id) : PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function create(Array $data) : PromiseInterface
    {
        return $this->correoExists($data['correo'])
            ->then(function(QueryResult $resultado){
                return empty($resultado->resultRows) ? resolve() : reject(new CorreoNoDisponible());
            })
            ->then(
                function() use ($data) {
                    return $this->identidadExists($data['identidad'])
                        ->then(function(QueryResult $resultado) use ($data) {
                            return empty($resultado->resultRows) ? resolve() : reject(new IdentidadNoDisponible());
                        });
                }
            )
            ->then(
                function() use ($data) {
                    $this->conexion->query('call SpNuevaPersona(1, ?, ?, ?, ?, ?, ?, ?, ?, ?);',
                        [
                            $data['contraseña'],
                            $data['p_nombre'],
                            $data['s_nombre'],
                            $data['p_apellido'],
                            $data['s_apellido'],
                            $data['correo'],
                            $data['f_nacimiento'],
                            $data['identidad'],
                            $data['idpais']
                        ]);
                    return KernelUsuario::kernelGetByCorreo($this->ciclo, $this->conexion, $data['correo'])
                            ->then(function(Usuario $usuario) use ($data) {
                                $usuario->contraseña = $data['contraseña_sin_hash'];
                                return $usuario;
                            }); # Hallar por correo
                }
            );
    }

    public function update(string $id, Array $data) : PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function delete(string $id) : PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function getAllById(string $id) : PromiseInterface
    {
        return $this->conexion->query('');
    }

    /*
        Funciones de ayuda para la autenticacion
    */

    public function correoExists(string $correo)
    {
        return $this->conexion->query('SELECT 1 FROM usuarios WHERE correo = ?', [$correo]);
    }

    public function identidadExists(string $identidad)
    {
        return $this->conexion->query('SELECT 1 FROM usuarios WHERE identidad = ?', [$identidad]);
    }

    public function iniciarSesion(Array $data)
    {
        return $this->conexion->query('SELECT idusuario, usuario, contraseña from usuarios WHERE usuario = ?', [$data['usuario']])
            ->then(
                function(QueryResult $resultado)
                {
                    if (!empty($resultado->resultRows))
                    {
                        $linea = $resultado->resultRows[0];
                        $id = (int) $linea['idusuario'];
                        $usuario = $linea['usuario'];
                        $contraseña = $linea['contraseña'];
                        return new Usuario($id, '', '', $usuario, $contraseña);
                    }else{
                        throw new UsuarioNoExiste();
                    }
                }
            );
    }


    public function generarCodigoRespaldo(string $correo)
    {
        return $this->correoExists($correo)
            ->then(function(QueryResult $resultado) use ($correo) {

                if(empty($resultado->resultRows)){
                    return reject(new UsuarioNoExiste());
                }

                $this->conexion->query('SET @codigo = null');
                $this->conexion->query('Call landtravel.SpNuevoCodigoRecuperacion(?, @codigo);', [$correo]);
                return $this->conexion->query('SELECT @codigo as codigo')
                    ->then(
                        function(QueryResult $resultado){
                            if (!empty($resultado->resultRows[0])) reject (new CodigoInvalido());
                            return $resultado->resultRows[0]['codigo'];
                        }
                    );
            });
    }

    public function restablecerContraseña(Array $data)
    {
        return $this->conexion->query('SELECT idusuario, usuario, c_respaldo FROM usuarios_codigos WHERE correo = ?', [$data['correo']])
            ->then(
                function(QueryResult $resultado) use ($data) {
                    
                    if (empty($resultado->resultRows) 
                        || ($data['codigo'] !== $resultado->resultRows[0]['c_respaldo']))
                        {
                        return reject(new CodigoInvalido());
                    }
                    
                    $data['usuario'] = $resultado->resultRows[0]['usuario'];
                    $nueva_contraseña = password_hash($data['nueva_contraseña'], PASSWORD_DEFAULT);

                    return $this->conexion->query('UPDATE usuario SET contraseña = ?, c_respaldo = null WHERE idusuario = ?',
                        [$nueva_contraseña, $resultado->resultRows[0]['idusuario']])
                        ->then(
                            function() use ($data)
                            {
                                return $data;
                            }
                        );
                }
            );
    }

    public function refrescarSesion()
    {

    }
}
