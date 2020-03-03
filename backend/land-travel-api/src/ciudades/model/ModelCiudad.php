<?php

namespace App\Ciudades\Model;

use App\Ciudades\Ciudad;
use App\Ciudades\Controllers\CiudadNoExiste;
use App\Hoteles\Kernel\KernelHoteles;
use App\Lugares\Kernel\KernelLugares;
use React\MySQL\QueryResult;

use function React\Promise\reject;
use function React\Promise\resolve;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;

use App\Nucleo\Interfaces\ModelInterface;


final class ModelCiudad implements ModelInterface
{
    protected $conexion;
    protected $ciclo;

    public function __construct(ConnectionInterface $conexion, LoopInterface $ciclo)
    {
        $this->conexion = $conexion;
        $this->ciclo = $ciclo;
    }

    public function getAll(): PromiseInterface
    {
        return $this->conexion->query('SELECT * FROM ciudades')
            ->then(
                function (QueryResult $resultado) {
                    $ciudades = [];
                    foreach ($resultado->resultRows as $linea) {
                        array_push($ciudades, Ciudad::Ciudad($linea));
                    }
                    return $ciudades;
                }
            )
            ->then(function (array $ciudades) {
                
                return KernelHoteles::kernelGetAll($this->ciclo, $this->conexion)->then(
                    function (array $hoteles) use ($ciudades) {
                        $llaves = array_keys($ciudades);
                        $tamaño = sizeof($ciudades);
                        $hoteles_s = [];

                        foreach ($ciudades as $ciudad) {
                            if (!isset($hoteles_s[$ciudad->idciudad])) {
                                $hoteles_s[$ciudad->idciudad] = [];
                            }
                        }

                        foreach ($hoteles as $hotel) {
                            array_push($hoteles_s[$hotel->idciudad], $hotel->toArray());
                        }
                        
                        for ($i = 0; $i < $tamaño; $i++) {
                            $ciudades[$llaves[$i]]->llenarHoteles($hoteles_s[$ciudades[$llaves[$i]]->idciudad]);
                        }

                        return KernelLugares::kernelGetAll($this->ciclo, $this->conexion)->then(
                            function(Array $lugares) use ($ciudades){
                                $llaves = array_keys($ciudades);
                                $tamaño = sizeof($ciudades);
                                $lugares_s = [];
        
                                foreach ($ciudades as $ciudad) {
                                    if (!isset($lugares_s[$ciudad->idciudad])) {
                                        $lugares_s[$ciudad->idciudad] = [];
                                    }
                                }
        
                                foreach ($lugares as $lugar) {
                                    array_push($lugares_s[$lugar->idciudad], $lugar->toArray());
                                }
                                
                                for ($i = 0; $i < $tamaño; $i++) {
                                    $ciudades[$llaves[$i]]->llenarLugares($lugares_s[$ciudades[$llaves[$i]]->idciudad]);
                                }

                                return $ciudades;
                            }
                        );
                    }
                );
            });
    }

    public function getOne(string $id): PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function (QueryResult $resultado) {
                    $ciudad = Ciudad::Ciudad($resultado->resultRows[0]);
                    return KernelHoteles::kernelGetAllById($this->ciclo, $this->conexion, $ciudad->idtour)
                        ->then(
                            function (array $rutas) use ($ciudad) {
                                $ciudad->llenarHoteles($rutas);
                                return $ciudad;
                            }
                        );
                }
            );
    }

    public function create(array $data): PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function update(string $id, array $data): PromiseInterface
    {
        return $this->conexion->query('');
    }

    public function delete(string $id): PromiseInterface
    {
        return $this->conexion->query('');
    }

    /* 
        Funciones adicionales para tours
    */

    public function exists(string $id)
    {
        return $this->conexion->query("SELECT * FROM tours where idtour = ?", [$id])
            ->then(
                function (QueryResult $resultado) {
                    if (empty($resultado->resultRows)) {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new CiudadNoExiste());
                    }

                    return $resultado;
                }
            );
    }

    public function updateCreate(string $id, array $data): PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function (QueryResult $resultado) use ($id, $data) {
                    return $this->update($id, $data);
                }
            )->then(
                null,
                function (CiudadNoExiste $excepcion) use ($data) {
                    return $this->create($data);
                }
            );
    }

    public function getAllById(string $id)
    {
    }
}
