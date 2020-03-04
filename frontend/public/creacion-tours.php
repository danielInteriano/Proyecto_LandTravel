<?php
require_once "../clases/conexion.php";
$obj = new conectar();
$conexion = $obj->conexion();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Creacion Tours</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/Creacion-Tours.css">
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
          <li><a href="creacion-tours.php">Agregar</a></li>
          <li><a href="modificar.php">Modificar</a></li>
          <li><a href="eliminar.php">Eliminar</a></li>
        </ul>
      </li>
    </ul>

  </nav>
  <a href="tours.php"><img style="width:40px; position: absolute;top:80px;left:30px;cursor:pointer;" src="../img/flecha_izquierda1.png" alt=""></a>
  <div id="imagenFondo">
  </div>
  <div class="container">
    <div class="row">

      <div class="col-12">
        <div class="box-create">
          <h2>Informaciòn de Tour</h2>
          <div id="linea"></div>
          <p>
            <label>Nombre</label><br>
            <input id="nombre" class="form-control" type="text" placeholder="Nombre del Tour">
          </p>
          <p>
            <label>Fecha de Inicio</label><br>
            <input id="fecha-inicio" class="form-control" type="date" placeholder="Nombre del Tour">
          </p>
          <p>
            <label>Cupos</label><br>
            <input id="cupo" class="form-control" type="text" placeholder="#Número de Cupos">
          </p>
          <p>
            <label>Tipo Tour</label><br>
            <select id="tipo-tour" class="form-control">
              <option value="" disabled selected hidden>-</option>
              <?php
              $sql = "select * from tipo_tour";
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
          <button id="button-create" style="margin-left: 40%;width: 150px;border-color: green;background-color: green !important;" type="button" class="btn btn-success">Crear Tour</button>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/creacion-tours.js"></script>
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