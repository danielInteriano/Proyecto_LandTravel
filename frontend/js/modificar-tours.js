$(document).ready(function (){
    console.log("Carga JS!");
});

function getURLParameter(name) {
	return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

$('#button-create').click(function(){

	var parametros = 
	{
        idtour : getURLParameter('tour'),
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
		url:"../php/modificarTour.php",
		success:function(resultado){
			console.log(resultado);
			let res = JSON.parse(resultado);
		
			if(res.creado === true){	
                location.href = 'Modificar.php';
			}else{
				alert(res.mensaje);
			}
		}
	});
});
