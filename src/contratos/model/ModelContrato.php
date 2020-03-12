<?php

namespace Backend\Contratos\Model;

use Backend\Contratos\Contrato;
use Backend\Contratos\Exceptions\ContratoNoExiste;
use React\MySQL\QueryResult;
use function React\Promise\reject;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use Backend\Nucleo\Interfaces\ModelInterface;

final class ModelContrato implements ModelInterface
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
        return $this->conexion->query('SELECT * FROM contratos')
            ->then(
                function(QueryResult $resultado)
                {   
                    $rutas = [];
                    foreach($resultado->resultRows as $linea)
                    {
                        array_push($rutas, Contrato::Contrato($linea));
                    }

                    return $rutas;
                }
            );
    }

    function getOne(string $id) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(QueryResult $resultado)
                {
                    return Contrato::Contrato($resultado->resultRows[0]);
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
                    $this->conexion->query('UPDATE contrato SET HABILITADO = 0 WHERE idcontrato = ?', [$id]);
                    return;
                }
            );
    }

    /* 
        Funciones adicionales para contrato
    */

     function exists(string $id)
    {
        return $this->conexion->query("SELECT * FROM contratos where idcontrato = ?", [$id])
            ->then(
                function (QueryResult $resultado)
                {
                    if(empty($resultado->resultRows))
                    {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new ContratoNoExiste());
                    }

                    return $resultado;
                }
            );
    }

    public function getAllById(string $idtour)
    {
        return $this->conexion->query('', [$idtour]);
    }
}