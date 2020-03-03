<?php 
	require_once "../clases/conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$codigo=$_POST['id'];
	$sql="select * from empleado emp
	inner join persona per on per.idpersona=emp.idpersona
	inner join pais pa on pa.idpais=per.idpais
	where per.idpersona='$codigo' and pa.Habilitado=1
	order by p_nombre asc";
	$result=mysqli_query($conexion,$sql);

	while (	$ver=mysqli_fetch_row($result))
	{	
	  $results[] = $ver;
	}

	echo json_encode($results);
 ?>