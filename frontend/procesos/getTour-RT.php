<?php 
	
	require_once "../clases/conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$codigo=$_POST['id'];
	$sql="SELECT 
 
	A.nombre as nombre_tour,
	Q.descripcion as nombre_ciudad, 
	CONCAT(L.p_nombre, ' ', L.p_apellido) as Nombre_Turista,
	L.identidad,
	L.f_nacimiento as Fecha_nacimiento,
	M.nacionalidad as nacionalidad,
	L.identidad,
	CONCAT(G.p_nombre, ' ', G.p_apellido) as Nombre_empleado,
	D.descripcion as nombre_transporte	 
   FROM tour A
   INNER JOIN ruta B
   ON A.idtour= B.idtour
   LEFT JOIN ruta_has_transporte C
   ON C.ruta_idruta=B.idruta
   INNER JOIN 	transporte D
   ON C.transporte_idtransporte=D.idtransporte
   RIGHT JOIN empleado_has_tour E
   ON A.idtour=E.tour_idtour
   INNER JOIN empleado F
   ON E.empleado_idpersona=F.idpersona
   LEFT JOIN persona G
   ON F.idpersona=G.idpersona
   RIGHT JOIN detalleFactura H
   ON A.idtour= H.tour_idtour
   LEFT JOIN factura J
   ON H.factura_idfactura= J.idfactura
   LEFT JOIN cliente K
   ON J.cliente_idcliente=K.idcliente
   LEFT JOIN PERSONA L
   ON J.cliente_idcliente=L.idpersona
   LEFT JOIN pais M
   on L.idpais=M.idpais
   LEFT JOIN paquete_hotel N 
   ON N.idpaquete_hotel = B.idpaquete
   LEFT JOIN HOTEL O 
   ON N.idhotel=O.IDHOTEL
   LEFT JOIN ciudad_has_hotel P 
   ON O.idhotel=P.hotel_idhotel
   LEFT JOIN ciudad Q
   ON Q.idciudad=P.ciudad_idciudad
   where A.idtour='$codigo'";
	$result=mysqli_query($conexion,$sql);

	while (	$ver=mysqli_fetch_row($result))
	{	
	  $results[] = $ver;
	}


	echo json_encode($results);
 ?>