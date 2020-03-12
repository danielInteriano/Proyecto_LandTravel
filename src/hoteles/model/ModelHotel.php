<?php

namespace Backend\Hoteles\Model;

use Backend\Hoteles\Hotel;
use React\MySQL\QueryResult;
use function React\Promise\reject;

use React\EventLoop\LoopInterface;
use function React\Promise\resolve;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;

use Backend\Hoteles\Exceptions\HotelNoExiste;
use Backend\Nucleo\Interfaces\ModelInterface;

final class ModelHotel implements ModelInterface
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
        return $this->conexion->query('SELECT * FROM hoteles')
            ->then(
                function(QueryResult $resultado)
                {   
                    $hoteles = [];
                    foreach($resultado->resultRows as $linea)
                    {
                        array_push($hoteles, Hotel::Hotel($linea));
                    }

                    return $hoteles;
                }
            );
    }

     function getOne(string $id) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(QueryResult $resultado)
                {
                    return Hotel::Hotel($resultado->resultRows[0]);
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
        return $this->conexion->query("SELECT * FROM hoteles where idhotel = ?", [$id])
            ->then(
                function (QueryResult $resultado)
                {
                    if(empty($resultado->resultRows))
                    {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new HotelNoExiste());
                    }

                    return $resultado;
                }
            );
    }

    public function getAllById(string $idtour)
    {
        return $this->conexion->query('SELECT * FROM rutas WHERE idtour = ?', [$idtour])
                ->then(
                    function(QueryResult $resultado)
                    {   
                        $hoteles = [];
                        foreach($resultado->resultRows as $linea)
                        {
                            array_push($hoteles, Hotel::Hotel($linea));
                        }
                        return $hoteles;
                    }
                );
    }
}