<?php

namespace App\Nucleo\Server;

use Exception;
use React\Http\Server;
use React\EventLoop\Factory;
use FastRoute\RouteCollector;
use App\Rutas\Model\ModelRuta;
use FastRoute\RouteParser\Std;
use App\Tours\Model\ModelTours;
use App\Usuarios\Model\ModelUsuario;
use App\Nucleo\Template\RouterTemplate;
use React\Socket\Server as ServerSocket;
use App\Rutas\Controller\GetRutasPorTour;
use App\Usuarios\Controllers\GetUsuarios;
use App\Nucleo\Middleware\RevisarConexion;
use App\Tours\Controllers\GetTours;
use App\Usuarios\Controllers\DeleteUsuario;
use App\Usuarios\Controllers\GetOneUsuario;
use FastRoute\DataGenerator\GroupCountBased;

final class ReactServer
{
    private $conexion;
    private $puerto;
    private $guard;
    private $rutas;
    private $ciclo;

    function __construct(int $puerto, string $uri)
    {
        $this->puerto = $puerto;
        $this->ciclo = Factory::create();

        /*
            En esta parte se crea la conexión a la base de datos. Un conexión
            perezosa es aquella que se crea de manera anticipada.
        */
        $mysql = new \React\MySQL\Factory($this->ciclo);
        $this->conexion = $mysql->createLazyConnection($uri);

        /*
            Los modelos se encargan de la manipulación de la base de datos,
            ya sea crear, modificar, o eliminar.
        */
        $modelo_usuarios = new ModelUsuario($this->conexion, $this->ciclo);
        $modelo_tours = new ModelTours($this->conexion, $this->ciclo);
        $modelo_rutas = new ModelRuta($this->conexion, $this->ciclo);

        /* 
            Creacion del grupo de las rutas, aqui se meteran las rutas de los
            routers para poder procesar las peticiones
        */
        $this->rutas = new RouteCollector(new Std(), new GroupCountBased());
        $this->rutas->addGroup('/usuarios', function () use ($modelo_usuarios){
            $this->rutas->get('', new GetUsuarios($modelo_usuarios));
            $this->rutas->get('/{id:\d+}', new GetOneUsuario($modelo_usuarios));
            $this->rutas->delete('/{id:\d+}', new DeleteUsuario($modelo_usuarios));
        });

        $this->rutas->addGroup('/tours', function () use ($modelo_tours){
            $this->rutas->get('', new GetTours($modelo_tours));
        });

        $this->rutas->addGroup('/rutas', function () use ($modelo_rutas){
            $this->rutas->get('/tour/{id:\d+}', new GetRutasPorTour($modelo_rutas));
        });
    }

    function iniciarCiclo()
    {
        // Server
        $middleware = [
            new RevisarConexion($this->conexion), 
            new RouterTemplate($this->rutas)
        ];
        
        $server = new Server($middleware);
        $socket = new ServerSocket($this->puerto, $this->ciclo);
        $server->listen($socket);

        // Se inicia el ciclo
        echo 'Se ha iniciado el server en: '. str_replace('tcp', 'http', $socket->getAddress()) . PHP_EOL;
        $this->ciclo->run();
    }
}