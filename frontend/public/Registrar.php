<?php 
require_once "../clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/estilos2.css">
    <link rel="icon" type="image/png" href="../img/favicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Courgette&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/alertify.min.css" />
<!-- include a theme -->
<link rel="stylesheet" href="../css/themes/default.min.css" />
    <script src="../js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
 
<div style="padding:0;margin: 0;">
        <img id="icono" src="img/Airport_48px.png" >
        <span onclick="document.location.href = 'index.php'" id="name-logo">Land Travel</span>
</div>
<div class="container">
<div class="row">
        <div class="col-12" style="align-content: left;">
                <section id ="div-login">
                        <h1>Registrar</h1>
                        <form>
                            <div class="row">
                                <div class="col-6">
                                        <input id="primer-nombre" type="text" placeholder="Primer Nombre"><br>
                                </div>
                                <div class="col-6">
                                        <input id="segundo-nombre" type="text" placeholder="Segundo Nombre"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                        <input id="primer-apellido" type="text" placeholder="Primer Apellido"><br>
                                </div>
                                <div class="col-6">
                                        <input id="segundo-apellido" type="text" placeholder="Segundo Apellido"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                        <input id="registro-correo" type="text" placeholder="Dirección de Correo"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                        <input id="registro-identidad" type="text" placeholder="Identidad"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                <select class="form-control" id="registro-pais">
                                <option value="" disabled selected hidden>Seleccione Pais</option>
				<?php 
			                $sql="select idpais,descripcion from pais;";
                                        $conexion=$obj->conexion();
                                        $result=mysqli_query($conexion,$sql);
                                       
			                while ($mostrar=mysqli_fetch_row($result)) {
				?>
                                        <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
				<?php 
			}
			mysqli_close($conexion);
			?>
				</select>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-12">
                                            <input id="registro-contrasenia" type="password" placeholder="Contraseña"><br>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-12">
                                                <input id="confirmar-contrasenia" type="password" placeholder="Confirmar Contraseña"><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-12">
                                                    <label>Fecha de Nacimiento</label><br>
                                                    <input id="registro-fechaNac" style="background-color: rgba(0, 0, 0, 0.103);" type="date" class="form-control" placeholder="Fecha-nacimiento"><br>
                                            </div>
                                        </div>
                            <button id="button-registrar" type="button">Registrarse</button>
                        </form>
                    </section> 
        </div>
        <div class="col-6"> 
        </div>
      </div>
    </div>
    <script src="../js/controlador-registrar.js"></script>
<!-- include the script -->
<script src="../js/alertify.min.js"></script>
    <script language="javascript">
    
    window.onload = function() {
     change();
    };

    function rand(){
     var argc = arguments.length, min, max;
     switch(argc){
      case 0:
       min=1;
       max=2;
      break;
      case 1:
       min = 1;
       max=arguments[0];
      break;
      default:
       min=arguments[0];
       max=arguments[1];
      break;
     }
     return Math.round(Math.random() * (max - min) + min);
    }
    function change(){
     document.body.style.backgroundImage='url(../img/bgr'+rand(4)+'.jpg)';
     document.body.style.backgroundRepeat='no-repeat';
     document.body.style.backgroundAttachment='fixed';
     document.body.style.backgroundSize='cover';
    }
            </script>
</body>
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
</script>
</html>

<!--  