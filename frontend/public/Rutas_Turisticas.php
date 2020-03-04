<?php 
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rutas Turísticas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Rutas_Turisticas.css">
    <link rel="icon" type="image/png" href="../img/favicon.ico" />
</head>
<nav class="navbar fixed-top navegacion">
      <ul class="nav">
      <li class="nav-item naveup"> <a href="#">Administración</a>
          <ul class="nave">
            <li><a href="index.php">Cerrar Sesión</a></li>
          </ul>
        </li>
        <li class="nav-item naveup"> <a href="#">Empleados</a>
          <ul class="nave">
            <li><a href="creacion-tours.php">Rutas Asignadas</a></li>
            <li><a href="VisualizarContratos.php">Contratos</a></li>
          </ul>
        </li>
        <li> <a href="404.php">Destinos</a></li>
        <li> <a href="infoServiCliente.php">Atencion Al Cliente</a></li>
        <li class="nav-item naveup"> <a href="#">Tours</a>
          <ul class="nave">
            <li><a href="creacion-tours.php">Agregar</a></li>
            <li><a href="Modificar.php">Modificar</a></li>
            <li><a href="Eliminar.php">Eliminar</a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <a href="tours.php"><img style="width:40px; position: absolute;top:80px;left:30px;cursor:pointer;" src="../img/flecha_izquierda1.png" alt=""></a>
    <div id="imagenFondo" style="" >
    </div>
<body background="img/ruta.jpg">
    <br><br>
  <div class="container-fluid" >
    <div class = "row">
        <br>
        
        
            <div class="col-xl-12 col-lg-12">
                <h2>Nombre Tour</h2>
                <select style="width:250px" id="rt-nombretour" class="col-xl-12 col-lg-12 form-control">
                <option value="" disabled selected hidden>-</option>
			      	<?php 
			                $sql="select * from tour";
                                        $conexion=$obj->conexion();
                                        $result=mysqli_query($conexion,$sql);
                                       
			                while ($mostrar=mysqli_fetch_row($result)) {
				?>
                                        <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[2]?></option>
				<?php 
			}
			mysqli_close($conexion);
			?>    
                </select>
            </div>


            <div class="col-xl-8 col-lg-8"><br>
            <div id="backdoor">
                <h3 style="margin-left: 40px;">Turistas participantes</h3>
                
                  
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th >Identidad</th>
                        <th >Nombre</th>
                        <th >Edad</th>
                        <th >Nacionalidad</th>
                      </tr>
                    </thead>
                    <tbody id="table-body-1">
                    </tbody>
                  </table>
                  <br>
                  <div  class="col-xl-4 col-lg-4"><button type="button" id="btbuscar">Guardar cambios</button></div>
                  </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <br>
                <h2 >Contactos</h2>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Telefono</th>
                        

                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td >Mark</td>
                        <td>88-44-5566</td>
                        
                        
                      </tr>
                      <tr>
                        <td >Mark</td>
                        <td>88-44-5566</td>
                        
                        
                      </tr>
                                       
                      </tr>
                    </tbody>
                  </table>
                  <h2>Empresa Transporte</h2>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Telefono</th>
                        

                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td >Mark</td>
                        <td>88-44-5566</td>
                        
                        
                      </tr>
                      <tr>
                        <td >Mark</td>
                        <td>88-44-5566</td>
                        
                        
                      </tr>
                                       
                      </tr>
                    </tbody>
                  </table>
                



                
            
            
            
            
            
            
            </div>
            

           
        
               
            
            
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

    </div>
  </div>
  <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/RutasTuristicas.js"></script>
    
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
          <img style="height: 140px;margin-left: 58px;" src="../img/logo.png" alt="">      </div>
        <div class="col col-lg-4 col-md-6 col-sm-12"><H6>
          <h6>UNAH</h6>
          <h6>Direccion</h6>
            <h6>Telefono</h6>
          
        </H3></div>
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