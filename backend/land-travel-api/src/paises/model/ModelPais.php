<?php

namespace App\Paises\Model;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use App\Nucleo\Interfaces\ModelInterface;

final class ModelPais implements ModelInterface
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
        return $this->conexion->query('SELECT * FROM pais');
    }

    public function getOne(string $id) : PromiseInterface
    {
        return $this->conexion->query('');
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
        return $this->conexion->query('');
    }

    public function getAllById(string $id) : PromiseInterface
    {
        return $this->conexion->query('');
    }
}