<?php

namespace App\Nucleo\Interfaces;

use React\EventLoop\LoopInterface;
use React\MySQL\ConnectionInterface;
use React\Promise\PromiseInterface;

interface ModelInterface
{
    public function __construct(ConnectionInterface $conexion, LoopInterface $loop);
    
    /**
     * Esta función debe poder retornar todos los registros de la base de datos,
     * la forma que se filtran o se ejecuta la query depende totalmente del
     * programador.
     * @return PromiseInterface Se retorna una PromiseInterface
    */
    public function getAll() : PromiseInterface;

    /**
     * Esta función debe poder retornar un registro de la base de datos,
     * la forma que se filtran o se ejecuta la query depende totalmente del
     * programador.
     * @return PromiseInterface
    */
    public function getOne(string $param) : PromiseInterface;

    /**
     * Esta función debe poder crear un registro en la base de datos,
     * idealmente se busca que retorne una respuesta, posiblemente una
     * en Json indicando del codigo que retorna, aunque 
     * también puede retornar un archivo, o enlace, esto atravez de la 
     * PromiseInterface.
     * @param Array data Datos a insertar
     * @return PromiseInterface
    */
    public function create(Array $data) : PromiseInterface;

    /**
     * Esta función debe poder borrar un registro de la base de datos,
     * o idealmente deshabilitarlo
     * @param string parametro Puede ser un id, o alguna caracteristica facilmente reconocible
     * @param Array Data Datos a insertar, preferiblemente un array asociativo
     * @return PromiseInterface
    */
    public function update(string $param, Array $data) : PromiseInterface;

    /**
     * Esta función debe poder borrar un registro de la base de datos,
     * o idealmente deshabilitarlo
     * @param string parametro Puede ser un id, o alguna caracteristica facilmente reconocible
     * @return PromiseInterface
    */
    public function delete(string $param) : PromiseInterface;


    /**
     * Esta función debe poder retornar todos lo registros de la base de datos,
     * con un id especificado
     * @param string parametro Puede ser un id, o alguna caracteristica facilmente reconocible
     * @return PromiseInterface
    */
    public function getAllById(string $id);
}
?>