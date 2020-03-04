$(document).ready(function (){
    console.log("Carga JS!");
});

$('#button-create').click(function(){

	var parametros = 
	{
        idtipo_tour : $("#tipo-tour").val(),
        nombre: $("#nombre").val(),
        fecha_inicio: $("#fecha-inicio").val(),
        cupo: $("#cupo").val(),
	};
	
	console.log(parametros);

	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'Json',
		url:"../php/nuevotour.php",
		success:function(resultado){
			console.log(resultado);
			let res = JSON.parse(resultado);
		
			if(res.creado === true){	
                //location.href = `creacion-rutas.php?id=${res.idtour}`;
			}else{
				alerty.error(res.mensaje);
			}
		}
	});
});
