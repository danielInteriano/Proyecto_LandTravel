<?php

namespace App\Nucleo\Server;

use Exception;
use React\Http\Server;
use React\EventLoop\Factory;
use App\Auth\Model\ModelAuth;

use FastRoute\RouteCollector;
use App\Rutas\Model\ModelRuta;
use FastRoute\RouteParser\Std;
use App\Tours\Model\ModelTours;
use App\Hoteles\Model\ModelHotel;
use App\Rutas\Controllers\GetRutas;
use App\Ciudades\Model\ModelCiudad;
use App\Lugares\Model\ModelLugares;
use App\Tours\Controllers\GetTours;
use App\Rutas\Controllers\CreateRuta;
use App\Usuarios\Model\ModelUsuario;
use App\Auth\Controllers\Registrarse;
use App\Tours\Controllers\DeleteTour;
use App\Tours\Controllers\GetOneTour;
use App\Auth\Controllers\IniciarSesion;
use App\Hoteles\Controllers\GetHoteles;
use App\Lugares\Controllers\GetLugares;
use App\Nucleo\Template\RouterTemplate;
use App\Hoteles\Controllers\GetOneHotel;
use App\Lugares\Controllers\GetOneLugar;
use React\Socket\Server as ServerSocket;
use App\Ciudades\Controllers\GetCiudades;
use App\Rutas\Controllers\GetRutasPorTour;
use App\Usuarios\Controllers\GetUsuarios;
use App\Nucleo\Middleware\RevisarConexion;
use App\Lugares\Controllers\GetLugaresById;
use App\Usuarios\Controllers\DeleteUsuario;
use App\Usuarios\Controllers\GetOneUsuario;
use FastRoute\DataGenerator\GroupCountBased;
use App\Auth\Controllers\GenerarCodigoRespaldo;
use App\Auth\Controllers\RestablecerContraseña;
use App\Auth\Controllers\RevisarCodigo;
use App\Contratos\Model\ModelContrato;
use App\Paises\Controllers\GetPais;
use App\Paises\Model\ModelPais;
use App\Rutas\Controllers\GetOneRuta;
use App\Tours\Controllers\CreateTour;
use App\Tours\Controllers\UpdateTour;

final class ReactServer
{
    private $conexion;
    private $puerto;
    private $guard;
    private $rutas;
    private $ciclo;

    function __construct(int $puerto, string $uri, string $jwt)
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
        $modelo_auth = new ModelAuth($this->conexion, $this->ciclo);
        $modelo_pais = new ModelPais($this->conexion, $this->ciclo);
        $modelo_ciudades = new ModelCiudad($this->conexion, $this->ciclo);
        $modelo_hoteles = new ModelHotel($this->conexion, $this->ciclo);
        $modelo_lugares = new ModelLugares($this->conexion, $this->ciclo);
        $modelo_contratos = new ModelContrato($this->conexion, $this->ciclo);

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

        /*
            Rutas para conseguir información de los tours
         */
        $this->rutas->addGroup('/tours', function () use ($modelo_tours){
            $this->rutas->get('', new GetTours($modelo_tours));
            $this->rutas->post('/crear', new CreateTour($modelo_tours));
            $this->rutas->get('/{id:\d+}', new GetOneTour($modelo_tours));
            $this->rutas->put('/{id:\d+}', new UpdateTour($modelo_tours));
            $this->rutas->delete('/{id:\d+}', new DeleteTour($modelo_tours));
        });

        $this->rutas->addGroup('/rutas', function () use ($modelo_rutas){
            $this->rutas->get('', new GetRutas($modelo_rutas));
            $this->rutas->get('/{id:\d+}', new GetOneRuta($modelo_rutas));
            $this->rutas->get('/tours/{id:\d+}', new GetRutasPorTour($modelo_rutas));
            $this->rutas->post('/crear', new CreateRuta($modelo_rutas));
        });


        $this->rutas->addGroup('/pais', function () use ($modelo_pais){
            $this->rutas->get('', new GetPais($modelo_pais));
        });

        $this->rutas->addGroup('/ciudades', function () use ($modelo_ciudades){
            $this->rutas->get('', new GetCiudades($modelo_ciudades));
        });

        $this->rutas->addGroup('/hoteles', function () use ($modelo_hoteles){
            $this->rutas->get('', new GetHoteles($modelo_hoteles));
            $this->rutas->get('/{id:\d+}', new GetOneHotel($modelo_hoteles));
        });

        $this->rutas->addGroup('/lugares', function () use ($modelo_lugares){
            $this->rutas->get('', new GetLugares($modelo_lugares));
            $this->rutas->get('/{id:\d+}', new GetOneLugar($modelo_lugares));
            $this->rutas->get('/ciudades/{id:\d+}', new GetLugaresById($modelo_lugares));
        });

        $this->rutas->addGroup('/auth', function () use ($modelo_auth, $jwt){
            $this->rutas->post('/registrarse', new Registrarse($modelo_auth));
            $this->rutas->post('/login', new IniciarSesion($modelo_auth, $jwt));
            $this->rutas->post('/revisarCodigo', new RevisarCodigo($modelo_auth));
            $this->rutas->put('/codigoRespaldo', new GenerarCodigoRespaldo($modelo_auth));
            $this->rutas->put('/restablecer', new RestablecerContraseña($modelo_auth));
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