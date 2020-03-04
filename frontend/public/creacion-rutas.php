<?php
require_once "../clases/conexion.php";
$obj = new conectar();
$conexion = $obj->conexion();

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $ch = curl_init('localhost:8080/tours/'.$id);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
 
  $result_php = json_decode($result, true);
  echo var_dump($result_php['tours']['rutas']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Creacion Tours</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/Creacion-rutas.css">
  <link rel="icon" type="image/png" href="../img/favicon.ico" />
</head>

<body>
  <nav class="navbar fixed-top navegacion">
    <ul class="nav">
      <li class="nav-item"><a href="#">Administracion</a></li>

      <li><a href="#">Guia De Turismo</a></li>

      <li> <a href="#">Destinos</a></li>
      <li> <a href="#">Atencion Al Cliente</a></li>
      <li class="nav-item naveup"> <a href="#">Tours</a>
        <ul class="nave">
          <li><a>Agregar</a></li>
          <li><a href="modificar.php">Modificar</a></li>
          <li><a href="eliminar.php">Eliminar</a></li>
        </ul>
      </li>
    </ul>

  </nav>
  <a href="tours.php"><img style="width:40px; position: absolute;top:80px;left:30px;cursor:pointer;" src="../img/flecha_izquierda1.png" alt=""></a>
  <div id="imagenFondo" style="">
  </div>
  <div class="container">
    <div class="row">
      <div class="col-4">
        <div class="box-create">
          <h2>Duracion de la Ruta</h2>
          <div id="linea"></div>
          <p>
            <label>Dias</label><br>
            <input id="create-dias" class="form-control" type="text" placeholder="Cantidad De Dias"><br>
            <label>Noches</label><br>
            <input id="create-noches" class="form-control" type="text" placeholder="Cantidad De Noches">
            <div class="formfecha">
          </p>

        </div>
      </div>

    </div>
    <div class="col-4 ">
      <div class="box-create">
        <h2>Informaciòn de Ruta</h2>
        <div id="linea"></div>
        <p>
          <label>Pais</label><br>
          <select id="create-pais" class="form-control">
            <option value="" disabled selected hidden>-</option>
            <?php
            $sql = "select idpais,descripcion from pais order by descripcion asc;";
            $conexion = $obj->conexion();
            $result = mysqli_query($conexion, $sql);

            while ($mostrar = mysqli_fetch_row($result)) {
            ?>
              <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
            <?php
            }
            mysqli_close($conexion);
            ?>
          </select>
        </p>
        <p>
          <label>Ciudad</label><br>
          <select id="create-ciudad" class="form-control">
            <option value="" disabled selected hidden>-</option>
          </select>
        </p>
        <p>
          <label data-toggle="modal" data-target="#exampleModal1" id="Create-tour" class="menu__item" role="menuitem">Lugares Turísticos</label><br>
          <select id="create-lugarturistico" class="form-control">
          </select>
        </p>

      </div>
    </div>
    <div class="col-4">
      <div class="box-create">
        <h2>Informaciòn de Ruta</h2>
        <div id="linea"></div>
        <p>
          <label>Guia De Turismo</label><br>
          <select id="create-guiaturismo" class="form-control">
            <option value="" disabled selected hidden>-</option>
            <?php
            $sql = "select idpersona,usu.idusuario, p_nombre,p_apellido from usuario usu
                      inner join usuario_tipos ut on usu.idusuario=usuario_idusuario
                      inner join tipo_usuario tu on tu.idtipo_usuario=ut.tipo_usuario_idtipo_usuario
                      inner join persona per on per.idusuario=usu.idusuario
                      where tu.idtipo_usuario=2";
            $conexion = $obj->conexion();
            $result = mysqli_query($conexion, $sql);

            while ($mostrar = mysqli_fetch_row($result)) {
            ?>
              <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[2] . ' ' . $mostrar[3] ?></option>
            <?php
            }
            mysqli_close($conexion);
            ?>
          </select>
        </p>
        <p>
          <label>Precio de RUTA</label><br>
          <input id="create-precioRutas" class="form-control" type="text" placeholder="Precio L.">
        </p>
        <p>
          <label>Precio TOTAL TOUR</label><br>
          <input disabled id="create-precioTotal" class="form-control" type="text" placeholder="L."><br>
        </p>

      </div>
    </div>
  </div>



  <div class="container formulario-footer">
    <div class="row">
      <div class="col col-lg-4">
        <p>
          <label>Transporte</label><br>
          <select id="create-transporte" class="form-control">
            <option value="" disabled selected hidden>-</option>
            <?php
            $sql = "select * from transporte";
            $conexion = $obj->conexion();
            $result = mysqli_query($conexion, $sql);

            while ($mostrar = mysqli_fetch_row($result)) {
            ?>
              <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
            <?php
            }
            mysqli_close($conexion);
            ?>
          </select>
        </p>
      </div>
      <div class="col col-lg-4">
        <p>
          <label>Hoteles</label><br>
          <select id="create-hotel" class="form-control">
          </select>
        </p>
      </div>
      <div class="col col-lg-4">
        <button id="button-create" style="margin-top: 32px;margin-left: 32px;width: 80%;background-color: green !important;" type="button" class="btn btn-success">Crear</button>
      </div>

    </div>
  </div>
  <h3>Rutas De Tours Creadas</h3>
  <table style="background-color:white; border-radius:10px;" class="table table-borderless">
    <thead>
      <tr>
        <th scope="col">Pais</th>
        <th scope="col">Ciudad</th>
        <th scope="col">Hotel</th>
        <th scope="col">Dias</th>
        <th scope="col">Noches</th>
        <th scope="col">Precio</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach($result['tours']['rutas'] as $ruta){
            echo ('<tr>'.
            '<th scope="row">'.$ruta['pais'].'</th>' .
            '<td>'.$ruta['ciudad'].'</td>' .
            '<td>'.$ruta['ciudad'].'</td>' .
            '<td>'.$ruta['hotel'].'</td>' .
            '<td>'.$ruta['c_dias'].'</td>' .
            '<td>'.$ruta['c_noches'].'</td>' .
            '<td>'.$ruta['precio_total'].'</td>' .
            "</tr>");
          }
        }
      ?>

    </tbody>
  </table>

  </p>
  </div>
  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/creacion-rutas.js"></script>
</body>

<footer>
  <div class="MD">
    <div class="contenedor container">
      <div class="row row1">
        <div class="col col-lg-6">
          <h6>
            <span style="margin-top: -10px;" id="name-logo">Land Travel</span>

          </h6>
        </div>
        <div class="col col-lg-6">
          <H6>
            CONTACTOS

          </H6>
        </div>
      </div>
      <div class="row ">
        <div class="col col-lg-4 col-md-6 col-sm-12">
          <img style="height: 140px;margin-left: 58px;" src="../img/logo.png" alt=""> </div>
        <div class="col col-lg-4 col-md-6 col-sm-12">
          <H6>
            <h6>UNAH</h6>
            <h6>Direccion</h6>
            <h6>Telefono</h6>

            </H3>
        </div>
        <div class="col col-lg-4 col-md-6 col-sm-12">
          <h6>
            CONTACTOS
          </h6>
        </div>
      </div>
      <div class="row derechos row2">
        <div class="col  col-lg-12">
          <h6 style="margin-top:-30px">@Todos los derechos reservados</h6>
        </div>
      </div>
    </div>
  </div>
</footer>

</html>