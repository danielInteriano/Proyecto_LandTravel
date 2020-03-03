<?php

namespace App\Paises\Model;

use App\Ciudades\Kernel\KernelCiudad;
use App\Paises\Pais;
use React\MySQL\QueryResult;
use function React\Promise\reject;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;

use App\Paises\Exceptions\PaisNoExiste;
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
        return $this->conexion->query('SELECT * FROM paises')
            ->then(
                function(QueryResult $resultado)
                {   
                    $paises = [];
                    foreach($resultado->resultRows as $linea){
                        array_push($paises, Pais::Pais($linea));
                    }

                    return KernelCiudad::kernelGetAll($this->ciclo, $this->conexion)->then(
                        function(Array $ciudades) use ($paises) {
                            $llaves = array_keys($paises);
                            $tamaño = sizeof($paises);
                            $ciudades_s = [];


                            foreach ($paises as $pais) {
                                if (!isset($ciudades_s[$pais->idpais])) {
                                    $ciudades_s[$pais->idpais] = [];
                                }
                            }

                            foreach ($ciudades as $ciudad) {
                                array_push($ciudades_s[$ciudad->idpais], $ciudad->toArray());
                            }
                            
                            for ($i = 0; $i < $tamaño; $i++) {
                                $paises[$llaves[$i]]->llenarCiudades($ciudades_s[$paises[$llaves[$i]]->idpais]);
                            }
                            return $paises;
                        }
                    );
                }
            );
    }

    public function getOne(string $id) : PromiseInterface
    {
        return $this->conexion->query('SELECT * FROM paises WHERE idpais = ?', [$id])
            ->then(
                function(QueryResult $resultado)
                {
                    if(empty($resultado->resultRows))
                    {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new PaisNoExiste());
                    }
                    return Pais::Pais($resultado->resultRows[0]);
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
        return $this->conexion->query('');
    }

    public function getAllById(string $id) : PromiseInterface
    {
        return $this->conexion->query('');
    }
}