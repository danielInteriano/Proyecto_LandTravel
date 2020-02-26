<?php

namespace App\Rutas\Model;

use App\Rutas\Ruta;
use React\MySQL\QueryResult;
use function React\Promise\reject;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use App\Nucleo\Interfaces\ModelInterface;
use App\Usuarios\Excepciones\UsuarioNoExiste;

final class ModelRuta implements ModelInterface
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
        return $this->conexion->query('SELECT * FROM ruta')
            ->then(
                function(QueryResult $resultado)
                {   
                    $rutas = [];
                    foreach($resultado->resultRows as $linea)
                    {
                        $idruta = $linea['idruta'];
                        $idtour = $linea['idtour'];
                        $paquete = $linea['idpaquete'];
                        $c_dias = $linea['c_dias'];
                        $c_noches = $linea['c_noches'];
                        $precio = $linea['precio'];
                        $pos = $linea['pos'];
                        array_push($rutas, new Ruta($idruta, $idtour, $paquete, $c_dias, $c_noches, $precio, $pos));
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
        return $this->conexion->query("SELECT * FROM usuarios where idusuario = ?", [$id])
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

    public function getAllById(string $idtour)
    {
        return $this->conexion->query('SELECT * FROM ruta WHERE idTour = ?', [$idtour])
                ->then(
                    function(QueryResult $resultado)
                    {   
                        $rutas = [];
                        foreach($resultado->resultRows as $linea)
                        {
                            $idtour = $linea['idtour'];
                            $idruta = $linea['idruta'];
                            $paquete = $linea['idpaquete'];
                            $c_dias = $linea['c_dias'];
                            $c_noches = $linea['c_noches'];
                            $precio = $linea['precio'];
                            $pos = $linea['pos'];
                            array_push($rutas, new Ruta($idruta, $idtour, $paquete, $c_dias, $c_noches, $precio, $pos));
                        }
                        return $rutas;
                    }
                );
    }
}