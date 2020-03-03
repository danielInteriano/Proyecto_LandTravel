<?php 
	
	require_once "../clases/conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$codigo=$_POST['id'];
	$sql="select idhotel,hot.descripcion from hotel hot 
		inner join ciudad_has_hotel cht on cht.hotel_idhotel=hot.idhotel
		inner join ciudad ciu on ciu.idciudad=cht.ciudad_idciudad
		where hot.idhotel='$codigo' and hot.habilitado=1
		order by hot.descripcion asc";
	$result=mysqli_query($conexion,$sql);

	while (	$ver=mysqli_fetch_row($result))
	{	
	  $results[] = $ver;
	}


	echo json_encode($results);
 ?>