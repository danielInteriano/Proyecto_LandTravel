<?php

namespace Backend\Nucleo\Server;

use React\Http\Server;
use Backend\Auth\Proteccion;
use React\EventLoop\Factory;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Backend\Auth\Model\ModelAuth;
use Backend\Rutas\Model\ModelRuta;
use Backend\Paises\Model\ModelPais;
use Backend\Tours\Model\ModelTours;
use Backend\Hoteles\Model\ModelHotel;
use Backend\Respuestas\RespuestaFile;
use Backend\Ciudades\Model\ModelCiudad;
use Backend\Lugares\Model\ModelLugares;
use Backend\Paises\Controllers\GetPais;
use Backend\Rutas\Controllers\GetRutas;
use Backend\Tours\Controllers\GetTours;
use Frontend\Vistas\Test as VistasTest;
use Backend\Usuarios\Model\ModelUsuario;
use React\Socket\Server as ServerSocket;
use Backend\Auth\Controllers\Registrarse;
use Backend\Rutas\Controllers\CreateRuta;
use Backend\Rutas\Controllers\GetOneRuta;
use Backend\Tours\Controllers\CreateTour;
use Backend\Tours\Controllers\DeleteTour;
use Backend\Tours\Controllers\GetOneTour;
use Backend\Tours\Controllers\UpdateTour;
use Backend\Contratos\Model\ModelContrato;
use Backend\Nucleo\Controllers\GetRecurso;
use Backend\Auth\Controllers\IniciarSesion;
use Backend\Auth\Controllers\RevisarCodigo;
use Backend\Hoteles\Controllers\GetHoteles;
use Backend\Lugares\Controllers\GetLugares;
use Backend\Nucleo\Controllers\GetResource;
use Backend\Nucleo\Template\RouterTemplate;
use Backend\Hoteles\Controllers\GetOneHotel;
use Backend\Lugares\Controllers\GetOneLugar;
use FastRoute\DataGenerator\GroupCountBased;
use Backend\Ciudades\Controllers\GetCiudades;
use Backend\Usuarios\Controllers\GetUsuarios;
use Backend\Nucleo\Middleware\RevisarConexion;
use Backend\Rutas\Controllers\GetRutasPorTour;
use Backend\Lugares\Controllers\GetLugaresById;
use Backend\Usuarios\Controllers\DeleteUsuario;
use Backend\Usuarios\Controllers\GetOneUsuario;
use Backend\Auth\Controllers\GenerarCodigoRespaldo;
use Backend\Auth\Controllers\RestablecerContraseña;
use Frontend\Vistas\Comprar;
use Frontend\Vistas\Index;
use Frontend\Vistas\Paquetes;

final class ReactServer
{
    private $conexion;
    private $puerto;
    private $guard;
    private $rutas;
    private $ciclo;

    function __construct(int $puerto, string $uri, string $jwt , $root = "")
    {
        $this->puerto = $puerto;
        $this->ciclo = Factory::create();

        /*
            Sirve para proteger; verifica que el usuario haya iniciado sesion
        */
        $this->guard = new Proteccion($jwt);
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

        /*

        
        */

        
        $this->rutas->addGroup('/html', function() use ($root) {

            $this->rutas->addGroup('/', function () use ($root){
                $this->rutas->get('', new Index());
                $this->rutas->get('test', new VistasTest());
                $this->rutas->get('comprar', new Comprar());
                $this->rutas->get('paquetes', new Paquetes());
            });

            $this->rutas->addGroup('/{raiz}', function () use ($root){
                $this->rutas->get('/{archivo}', new GetRecurso($root));
                $this->rutas->get('/{carpeta}/{archivo}', new GetRecurso($root));
                $this->rutas->get('/{carpeta1}/{carpeta2}/{archivo}', new GetRecurso($root));    
            });
        });
        
        /*
            Creacion de las rutas de los usuarios
        */
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


        $this->rutas->addGroup('/paises', function () use ($modelo_pais){
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