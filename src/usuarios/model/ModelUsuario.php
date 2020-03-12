<?php

namespace Backend\Usuarios\Model;

use Backend\Usuarios\Usuario;
use React\MySQL\QueryResult;
use function React\Promise\reject;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;

use Backend\Nucleo\Interfaces\ModelInterface;
use Backend\Usuarios\Exceptions\UsuarioNoExiste;

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
                    foreach($resultado->resultRows as $linea){
                        array_push($usuarios, Usuario::Usuario($linea));
                    }
                    return $usuarios;
                }
            );
    }

    public function getOne(string $id) : PromiseInterface
    {
        return $this->exists($id);
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
                function (Usuario $usuario) use ($id)
                {
                    $this->conexion->query('UPDATE usuario SET HABILITADO=0 WHERE idusuario = ?', [$id]);
                    return;
                }
            );
    }

    public function getAllById(string $id)
    {
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
                    return Usuario::Usuario($resultado->resultRows[0]);
                }
            );
    }

    public function updateCreate(string $id, Array $data) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(Usuario $usuario) use($id,$data)
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

    public function existsCorreo(string $correo)
    {
        return $this->conexion->query('SELECT * from usuarios where correo = ?', [$correo])
            ->then(
                function(QueryResult $resultado){
                    if(empty($resultado->resultRows)){
                        return reject(new UsuarioNoExiste());
                    }
                    return Usuario::Usuario($resultado->resultRows[0]);
                }
            );
    }
}