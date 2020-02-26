<?php

namespace App\Usuarios\Model;

use App\Usuarios\Usuario;
use React\MySQL\QueryResult;
use function React\Promise\reject;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;

use App\Nucleo\Interfaces\ModelInterface;
use App\Usuarios\Excepciones\UsuarioNoExiste;

final class ModelUsuario implements ModelInterface
{
    protected $conexion;
    protected $loop;

    public function __construct(ConnectionInterface $conexion, LoopInterface $loop)
    {
        $this->conexion = $conexion;
        $this->loop = $loop;
    }

    public function getAll() : PromiseInterface
    {
        return $this->conexion->query('SELECT * FROM usuarios')
            ->then(
                function(QueryResult $resultado)
                {   
                    $usuarios = [];
                    foreach($resultado->resultRows as $linea)
                    {
                        $idusuario = $linea['idusuario'];
                        $nombres = $linea['nombres'];
                        $apellidos = $linea['apellidos'];
                        $usuario = $linea['usuario'];
                        $correo = $linea['correo'];
                        $pais = $linea['pais'];
                        $f_registro = $linea['f_registro'];
                        array_push($usuarios, new Usuario($idusuario, $nombres, $apellidos, $usuario, 
                                                            $correo, $pais, $f_registro));
                    }
                    return $usuarios;
                }
            );
    }

    public function getOne(string $id) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(QueryResult $resultado)
                {
                    $linea = $resultado->resultRows[0];
                    $idusuario = $linea['idusuario'];
                    $nombres = $linea['nombres'];
                    $apellidos = $linea['apellidos'];
                    $usuario = $linea['usuario'];
                    $correo = $linea['correo'];
                    $pais = $linea['pais'];
                    $f_registro = $linea['f_registro'];
                    return new Usuario($idusuario, $nombres, $apellidos, $usuario, 
                                        $correo, $pais, $f_registro);
                }
            );
    }
    
    public function create(Array $data) : PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function update(string $id, Array $data) : PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function delete(string $id) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function (QueryResult $resultado) use ($id)
                {
                    $this->conexion->query('UPDATE usuario SET HABILITADO=0 WHERE idusuario = ?', [$id]);
                    return;
                }
            );
    }

    /* 
        Funciones adicionales para usuario
    */

    public function exists(string $id)
    {
        return $this->conexion->query("SELECT * FROM usuarios where idusuario = ?", [$id])
            ->then(
                function (QueryResult $resultado)
                {
                    if(empty($resultado->resultRows))
                    {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new UsuarioNoExiste());
                    }

                    return $resultado;
                }
            );
    }

    public function updateCreate(string $id, Array $data) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(QueryResult $resultado) use($id,$data)
                {
                    return $this->update($id, $data);
                }
            )->then(null,
                function(UsuarioNoExiste $excepcion) use($data)
                {
                    return $this->create($data);
                }
            );
    }

    public function getAllById(string $id)
    {
    }
}