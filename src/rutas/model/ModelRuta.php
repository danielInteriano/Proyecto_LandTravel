<?php

namespace Backend\Rutas\Model;

use Backend\Rutas\Ruta;
use React\MySQL\QueryResult;
use function React\Promise\reject;
use function React\Promise\resolve;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\MySQL\ConnectionInterface;
use Backend\Nucleo\Interfaces\ModelInterface;
use Backend\Rutas\Exceptions\ErrorCreacionRutas;
use Backend\Rutas\Exceptions\RutaNoExiste;
use Backend\Usuarios\Excepciones\UsuarioNoExiste;
use RuntimeException;

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
        return $this->conexion->query('SELECT * FROM rutas')
            ->then(
                function(QueryResult $resultado)
                {   
                    $rutas = [];
                    foreach($resultado->resultRows as $linea)
                    {
                        array_push($rutas, Ruta::Ruta($linea));
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
                    return Ruta::Ruta($resultado->resultRows[0]);
                }
            );
    }
    
     function create(Array $data) : PromiseInterface
    {
        $this->conexion->query('SET @codigo_error = 0;');
        $this->conexion->query('CALL landtravel.SpNuevaRuta(?, ?, ?, ?, ?, ?, ?, ?, @codigo_error);', 
        [
            $data['idtour'],
            $data['idpaquete'],
            $data['idtransporte'],
            $data['idlugar'],
            $data['idguia'],
            $data['c_dias'],
            $data['c_dias'],
            $data['precio'],
        ]);
        return $this->conexion->query('SELECT @codigo_error as error;')
            ->then(function(QueryResult $resultado){
                
                if($resultado->resultRows[0]['error'] !== '0')
                {
                    return reject(new ErrorCreacionRutas());
                }
                return resolve([]);
            });
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
        return $this->conexion->query("SELECT * FROM rutas where idruta = ?", [$id])
            ->then(
                function (QueryResult $resultado)
                {
                    if(empty($resultado->resultRows))
                    {
                        // Reject es básicamente un throw, permite hacer error handling.
                        return reject(new RutaNoExiste());
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
                        $rutas = [];
                        foreach($resultado->resultRows as $linea)
                        {
                            array_push($rutas, Ruta::Ruta($linea));
                        }
                        return $rutas;
                    }
                );
    }
}