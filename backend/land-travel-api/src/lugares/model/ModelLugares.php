<?php

namespace App\Lugares\Model;

use App\Lugares\Lugar;
use React\MySQL\QueryResult;
use function React\Promise\reject;

use React\EventLoop\LoopInterface;
use function React\Promise\resolve;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use App\Lugares\Exceptions\LugarNoExiste;
use App\Nucleo\Interfaces\ModelInterface;

final class ModelLugares implements ModelInterface
{
    public $conexion;
    protected $loop;

    public function __construct(ConnectionInterface $conexion, LoopInterface $loop)
    {
        $this->conexion = $conexion;
        $this->loop = $loop;
    }

    function getAll() : PromiseInterface
    {
        return $this->conexion->query('SELECT * FROM lugares')
            ->then(
                function(QueryResult $resultado)
                {   
                    $lugares = [];
                    foreach($resultado->resultRows as $linea)
                    {
                        array_push($lugares, Lugar::Lugar($linea));
                    }

                    return $lugares;
                }
            );
    }

     function getOne(string $id) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(QueryResult $resultado)
                {
                    return Lugar::Lugar($resultado->resultRows[0]);
                }
            );
    }
    
     function create(Array $data) : PromiseInterface
    {
        return $this->conexion->query('');
    }

     function update(string $id, Array $data) : PromiseInterface
    {
        return $this->conexion->query('');
    }

     function delete(string $id) : PromiseInterface
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

     function exists(string $id)
    {
        return $this->conexion->query("SELECT * FROM lugares where idlugar = ?", [$id])
            ->then(
                function (QueryResult $resultado)
                {
                    if(empty($resultado->resultRows))
                    {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new LugarNoExiste());
                    }

                    return $resultado;
                }
            );
    }

    public function getAllById(string $idciudad)
    {
        return $this->conexion->query('SELECT * FROM lugares WHERE idciudad = ?', [$idciudad])
                ->then(
                    function(QueryResult $resultado)
                    {   
                        $rutas = [];
                        foreach($resultado->resultRows as $linea)
                        {
                            array_push($rutas, Lugar::Lugar($linea));
                        }
                        return $rutas;
                    }
                );
    }
}