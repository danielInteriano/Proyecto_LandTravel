<?php

namespace App\Tours\Model;

use App\Tours\Tour;
use React\MySQL\QueryResult;
use App\Rutas\Kernel\KernelRutas;
use function React\Promise\reject;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use App\Tours\Exceptions\TourNoExiste;
use App\Nucleo\Interfaces\ModelInterface;

final class ModelTours implements ModelInterface
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
        return $this->conexion->query('SELECT * FROM tours')
            ->then(
                function (QueryResult $resultado) {
                    $tours = [];
                    foreach ($resultado->resultRows as $linea) {
                        $idtour = $linea['idtour'];
                        $descripcion = $linea['descripcion'];
                        $nombre_tour = $linea['nombre_tour'];
                        $cupo = $linea['cupo'];
                        array_push($tours, new Tour($idtour, $descripcion, $nombre_tour, $cupo));
                    }
                    return $tours;
                }
            )
            ->then(function (array $tours) {

                return KernelRutas::kernelGetAll($this->ciclo, $this->conexion)->then(
                    function (array $rutas) use ($tours) {
                        $llaves = array_keys($tours);
                        $tamaño = sizeof($tours);
                        $rutas_s = [];

                        foreach ($rutas as $ruta) {
                            if (!isset($rutas_s[$ruta->idtour])) {
                                $rutas_s[$ruta->idtour] = [];
                            }
                            array_push($rutas_s[$ruta->idtour], $ruta->toArray());
                        }

                        for ($i = 0; $i < $tamaño; $i++) {
                            $tours[$llaves[$i]]->llenarRutas($rutas_s[$tours[$llaves[$i]]->idtour]);
                        }
                        return $tours;
                    }
                );
            });
    }

    public function getOne(string $id): PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function (QueryResult $resultado) {
                    $linea = $resultado->resultRows[0];
                    $idtour = $linea['idtour'];
                    $descripcion = $linea['descripcion'];
                    $nombre_tour = $linea['nombre_tour'];
                    $cupo = $linea['cupo'];

                    return KernelRutas::kernelGetAllById($this->ciclo, $this->conexion, $idtour)
                        ->then(
                            function (array $rutas) use ($idtour, $descripcion, $nombre_tour, $cupo) {
                                $tour = new Tour($idtour, $descripcion, $nombre_tour, $cupo);
                                $tour->llenarRutas($rutas);
                                return $tour;
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
        return $this->exists($id)
            ->then(
                function (QueryResult $resultado) use ($id) {
                    $this->conexion->query('UPDATE tour SET HABILITADO=0 WHERE idtour = ?', [$id]);
                }
            );
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
                        return reject(new TourNoExiste());
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
                function (TourNoExiste $excepcion) use ($data) {
                    return $this->create($data);
                }
            );
    }

    public function getAllById(string $id)
    {
    }
}
