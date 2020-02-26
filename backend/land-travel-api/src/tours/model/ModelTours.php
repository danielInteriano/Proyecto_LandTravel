<?php

namespace App\Tours\Model;

use App\Tours\Tour;
use React\Promise\Promise;
use React\Promise\Deferred;
use React\MySQL\QueryResult;

use Recoil\React\ReactKernel;

use App\Rutas\Model\ModelRuta;
use function React\Promise\reject;
use function React\Promise\resolve;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use App\Nucleo\Interfaces\ModelInterface;
use App\Rutas\Kernel\KernelRutas;
use App\Rutas\Ruta;
use App\Usuarios\Excepciones\UsuarioNoExiste;
use React\EventLoop\LoopInterface;

final class ModelTours implements ModelInterface
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
        return $this->conexion->query('SELECT * FROM tours')
            ->then(
                function(QueryResult $resultado)
                {   
                    $tours = [];
                    foreach($resultado->resultRows as $linea)
                    {
                        $idtour = $linea['idtour'];
                        $descripcion = $linea['descripcion'];
                        $nombre_tour = $linea['nombre_tour'];
                        $cupo = $linea['cupo'];
                        array_push($tours, new Tour($idtour, $descripcion, $nombre_tour, $cupo));
                    }
                    return $tours;
                }
            )
            ->then(function(Array $tours){
                $rutas_m = ReactKernel::start(function() 
                {
                    $resultado = KernelRutas::kernelGetAll($this->loop, $this->conexion);
                    yield;
                    return $resultado;
                });

                return $rutas_m->then(
                    function(Array $rutas) use ($tours) {
                        $llaves = array_keys($tours);
                        $tamaño = sizeof($tours);
                        $rutas_s = [];

                        foreach($rutas as $ruta)
                        {
                            if(!isset($rutas_s[$ruta->idtour]))
                            {
                                $rutas_s[$ruta->idtour] = [];
                            }
                            array_push($rutas_s[$ruta->idtour], $ruta->toArray());
                            
                        }

                        var_dump($rutas_s);

                        for ($i=0; $i<$tamaño; $i++)
                        {
                           $tours[$llaves[$i]]->rutas = $rutas_s[$tours[$llaves[$i]]->idtour];
                        }
                        return $tours;
                    }
                );          
            });
    }

    public function getOne(string $id) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(QueryResult $resultado)
                {
                    $linea = $resultado->resultRows[0];
                    $idtour = $linea['idtour'];
                    $nombre_guia = $linea['nombre_guia'];
                    $descripcion = $linea['descripcion'];
                    $nombre_tour = $linea['nombre_tour'];
                    $cupo = $linea['cupo'];
                    array_push($usuarios, new Tour($idtour, $nombre_guia, $descripcion, $nombre_tour, $cupo));
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

    public function exists(string $id)
    {
        return $this->conexion->query("SELECT * FROM tours where idtour = ?", [$id])
            ->then(
                function (QueryResult $resultado)
                {
                    if(empty($resultado->resultRows))
                    {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new UsuarioNoExiste());
                    }

                    return $resultado;
                }
            );
    }

    public function updateCreate(string $id, Array $data) : PromiseInterface
    {
        return $this->exists($id)
            ->then(
                function(QueryResult $resultado) use($id,$data)
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

    public function getAllById(string $id)
    {
    }
}