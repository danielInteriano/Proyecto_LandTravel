<?php 
	
	require_once "../clases/conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$codigo=$_POST['id'];
	$sql="select * from empleado emp
	inner join persona per on per.idpersona=emp.idpersona
    inner join contrato con on con.idcontrato=emp.contrato_idcontrato
    inner join tipo_contrato tc on tc.idtipo_contrato=con.idtipo_contrato where per.idpersona=$codigo";
	$result=mysqli_query($conexion,$sql);

	while (	$ver=mysqli_fetch_row($result))
	{	
	  $results[] = $ver;
	}


	echo json_encode($results);
 ?>