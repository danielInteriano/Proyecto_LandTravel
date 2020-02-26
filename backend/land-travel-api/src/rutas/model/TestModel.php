<?php

namespace App\Rutas\Model;

use React\EventLoop\LoopInterface;
use React\MySQL\ConnectionInterface;

final class TestModel 
{
    protected $conexion;
    protected $loop;

    public function __construct(ConnectionInterface $conexion, LoopInterface $loop)
    {
        $this->conexion = $conexion;
        $this->loop = $loop;
    }
}