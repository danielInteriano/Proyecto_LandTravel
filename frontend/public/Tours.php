<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=;, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>TOURS</title>
  <link rel="icon" type="image/png" href="../img/favicon.ico" />
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/tours.css">
  <link href="https://fonts.googleapis.com/css?family=Courgette&display=swap" rel="stylesheet">
  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>

  <style type="text/css">
    ul,
    ol {
      list-style: none;

    }
  </style>
  
</head>
<header>
    <nav class="navbar fixed-top navegacion">
      <ul class="nav">
        <li class="nav-item"><a href="#">Administracion</a></li>

        <li><a href="#">Guia De Turismo</a></li>

        <li> <a href="#">Destinos</a></li>
        <li> <a href="#">Atencion Al Cliente</a></li>
        <li class="nav-item naveup"> <a href="#">Tours</a>
          <ul class="nave">
            <li><a href="creacion-tours.php">Agregar</a></li>
            <li><a href="">Modificar</a></li>
            <li><a href="">Eliminar</a></li>
          </ul>
        </li>
      </ul>
    </nav>

    <div class="bd-example">
      <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
          <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../img/1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5 class="Letras">Viaja</h5>
              <p>Al lugar de tus sueños.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../img/2.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5 style="color:black;" class="Letras">Disfruta</h5>
              <p style="color:black;">Los Mejores Lugares.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../img/1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5 class="Letras">Atrevete a soñar</h5>
             
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </header>
<body id="body">
  
  <div class="Contenedor container-fluid">
    <div class="row">
      <div class="img-1 col col-lg-3 col-sm-1">
        <img class="pt" src="../img/r1.jpg" id="img-roatan"><br>
        <h3>Honduras</h3>
      </div>
      <div class="img-2 col col-lg-3 col-sm-1">
        <img class="pt" src="../img/canvas.png"><br>
        <h3>EEUU</h3>
      </div>
      <div class="img-3 col col-lg-3 col-sm-1">
        <img class="pt" src="../img/Disney.png">
        <h3>Disney</h3>
      </div><br>


      <div class="img-4  col-lg-3 col-sm-1">
        <img class="pt" src="../img/Espa_a.png"><br>
        <h3>España</h3>
      </div>
      <div class="img-6 col col-lg-3 col-sm-1">
        <img class="pt" src="../img/Dubai.png"><br>
        <h3>Dubai</h3>
      </div>
      <div class="img-7 col col-lg-3 col-sm-1">
      <img class="pt" src="../img/inglaterra.jpg "><br>
      <h3>Inglaterra</h3>
            
    </div>
      <div class="img-8 col col-lg-3 col-sm-1">
      <img  class="pt" src="../img/japon.png "><br>
      <h3>Japon</h3>
    </div>
      
      <div class="img-9 col col-lg-3 col-sm-1">
      <img class="pt"   src="../img/suiza.png"><br>
      <h3>Suiza</h3>

    </div>
      


  </div>

  

  <div>




  </div>


  <div class="modal  " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Roatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Roatán es una de las Islas de la Bahía de<br>
          Honduras en el Caribe. <br>
          Forma parte del enorme Sistema Arrecifal
          Mesoamericano y es conocida por las playas,
          los sitios de buceo y la fauna marina, incluido
          el tiburón ballena
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success">Viajar</button>
        </div>
      </div>
    </div>
  </div>


  <script src="../js/tours.js"></script>
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