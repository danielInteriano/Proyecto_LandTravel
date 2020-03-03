<?php 
	
	require_once "../clases/conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$codigo=$_POST['id'];
	$sql="select * from ciudad 
	where idpais='$codigo'
	order by descripcion asc";
	$result=mysqli_query($conexion,$sql);

	while (	$ver=mysqli_fetch_row($result))
	{	
	  $results[] = $ver;
	}


	echo json_encode($results);
 ?>