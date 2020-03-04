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
    <title>Empleados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Empleados.css">
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
    <div id="imagenFondo" style="" >
    </div>  
<body id="body" background="img/is.jpg">
    <div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-lg-6 ">
            <br>
            <h2>Listado de empleados</h2>
            <br>
            <select id="select-empleado" name="select" class="col-xl-12 col-lg-12 form-control ">
            <option value="" disabled selected hidden>-</option>
				<?php 
			                $sql="select * from empleado emp
                      inner join persona per on per.idpersona=emp.idpersona
                      inner join pais pa on pa.idpais=per.idpais
                      order by p_nombre asc";
                                        $conexion=$obj->conexion();
                                        $result=mysqli_query($conexion,$sql);
                                       
			                while ($mostrar=mysqli_fetch_row($result)) {
				?>
                                        <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[4].' '.$mostrar[5].' '.$mostrar[6].' '.$mostrar[7] ?></option>
				<?php 
			}
			mysqli_close($conexion);
			?>
            </select>
            <br><br><br>
            <div class="col-xl-6 col-lg-6">
                <h2>Datos empleado</h2>
            </div>
            



            
            <div class="col-xl-6 col-lg-6">

                <label>Identidad</label>       
                <input id="emp-identidad" class="form-control" type="text" >
                
                
            </div>
            <div class="container-fluid">
                <div class="row">

                    <div class="col-xl-6 col-lg-6">


                        <label>Primer Nombre</label><br>
                        <input id="emp-pnombre" class="form-control" type="text" >
                        
                        <label>Segundo Nombre</label><br>
                        <input id="emp-snombre" class="form-control" type="text" >
                        
                        <label>Primer Apellido</label><br>
                        <input id="emp-papellido" class="form-control" type="text" >
                       
                        <label>Segundo Apellido</label><br>
                        <input id="emp-sapellido" class="form-control" type="text" >
                        
                        
                                      
                                                
                    </div>   
                    <div class="col-xl-6 col-lg-6"> 
                        <label>Fecha de Nacimiento</label><br>
                        <input id="emp-fnac" class="form-control" type="text" >
                        
                        <label>Pais</label><br>
                        <input id="emp-pais" class="form-control" type="text" >
                        
                        <label>Correo</label><br>
                        <input id="emp-correo" class="form-control" type="text" >
                        
                        <label>Nacionalidad</label><br>
                        <input id="emp-nacionalidad" class="form-control" type="text" >
                        
                    </div>
                    
                    
                    <div class="col-xl-12 col-lg-12"> 
                        <br>
                        
                    </div>

                  <!------  <div class="col-xl-12 col-lg-12"><button class="btn btn-success" id="btbuscar">Guardar cambios</button></div>-->
                </div>
            </div>
            
                                              
        </div>



        <div class="col-xl-6 col-lg-6">



            <div class="container-fluid">
                <div class="row">           

                <div class="col-xl-6 col-lg-6">
                    <br><br>
              
                    <br><br>
                    <h2 style="width: 336px;">Historial de Tours/Rutas</h2>
            </div>


            
              
              <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Paquete</th>
                    
                    <th scope="col">Fecha</th>
                  </tr>
                </thead>
                <tbody id="table-empleado">
                 
                </tbody>
              </table>
              <br><br><br><br><br>
              
              
              <h2>Datos del contrato</h2>
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-xl-6 col-lg-6">
                                              
                       
                      <label>Salario</label>
                      <input class="form-control" type="text" placeholder="L." disabled>
                  </div>
                  
      
      
      
                  
                  <div class="col-xl-6 col-lg-6">
                            
                      <label>Numero de cuenta</label>       
                      <input class="form-control" type="text"disabled >
                      <br><br><br>
                      
                  </div>

                  </div>
              </div>
              

                </div>
            </div>
           
        </div>
      </div>
    
</div>
<script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Empleados.js"></script>
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