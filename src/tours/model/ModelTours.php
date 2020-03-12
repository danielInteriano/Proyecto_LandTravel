<?php

namespace Backend\Tours\Model;

use Backend\Tours\Tour;
use React\MySQL\QueryResult;
use Backend\Rutas\Kernel\KernelRutas;
use function React\Promise\reject;
use function React\Promise\resolve;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use Backend\Tours\Exceptions\TourNoExiste;
use Backend\Nucleo\Interfaces\ModelInterface;
use Backend\Tours\Exceptions\ErrorCreacionTours;

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
                        array_push($tours, Tour::Tour($linea));
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

                        foreach ($tours as $tour) {
                            if (!isset($rutas_s[$tour->idtour])) {
                                $rutas_s[$tour->idtour] = [];
                            }
                        }

                        foreach ($rutas as $ruta) {
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
                    $tour = Tour::Tour($resultado->resultRows[0]);
                    return KernelRutas::kernelGetAllById($this->ciclo, $this->conexion, $tour->idtour)
                        ->then(
                            function (array $rutas) use ($tour) {
                                $tour->llenarRutas($rutas);
                                return $tour;
                            }
                        );
                }
            );
    }

    public function create(array $data): PromiseInterface
    {
        $this->conexion->query('SET @codigo_error = 0;');
        $this->conexion->query('CALL landtravel.SpNuevoTour(null, ?, ?, ?, ?, @codigo_error);', 
        [
            $data['idtipo_tour'],
            $data['nombre'],
            $data['fecha_inicio'],
            $data['cupo']
        ]);
        return $this->conexion->query('SELECT @codigo_error as error;')
            ->then(function(QueryResult $resultado){

                if($resultado->resultRows[0]['error'] !== '0')
                {
                    return reject(new ErrorCreacionTours());
                }
                return $this->conexion->query('SELECT MAX(idtour) as id FROM tours')
                    ->then(
                        function(QueryResult $resultado){
                            return $resultado->resultRows[0]['id'];
                        }
                    );
            });
    }

    public function update(string $id, array $data): PromiseInterface
    {
        $this->conexion->query('SET @codigo_error = 0;');
        $this->conexion->query('CALL landtravel.SpNuevoTour(?, ?, ?, ?, ?, @codigo_error);', 
        [
            $id,
            $data['idtipo_tour'],
            $data['nombre'],
            $data['fecha_inicio'],
            $data['cupo']
        ]);

        return $this->conexion->query('SELECT @codigo_error as error;')
            ->then(function(QueryResult $resultado){

                if($resultado->resultRows[0]['error'] != '0')
                {
                    return reject(new ErrorCreacionTours());
                }
                return resolve();
            });
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
