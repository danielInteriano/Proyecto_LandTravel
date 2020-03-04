$(document).ready(function() {
	//alertify.success("¡Bienvenido!");
	console.log("Funciona JS");
})

var cod;
var corr;

$('#button-1').click(function(){
	
	var correo= $("#recuperar-correo").val();
	corr = correo;
	
	if (correo != '') {
		$.ajax({
			type:"POST",
			data: {'correo': correo },
			datatype:'json',
			url:"../php/lost.php",
			success:function(resultado){
				console.log(resultado);
				let res = JSON.parse(resultado);
				if(res.creado === true){
					$('#div-login').css('display','none');
					$('#div-recuperar').css('display','block');				
				}else{
					console.log(resultado);
				}
			}
		});
	}
});

$('#button-codigo').click(function(){

	var parametros= 
    "codigo="+$("#recuperar-codigo").val();
	cod = $("#recuperar-codigo").val();

	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'Json',
		url:"../php/introducirCodigo.php",
		success:function(resultado){
			let res = JSON.parse(resultado);
			if(res.hecho === true){
				$('#div-contrasenia').css('display','block');
				$('#div-recuperar').css('display','none');		
			}else{
				console.log(resultado);
			}
		}
	});
});

$("#button-escribir").click(function(){
	$('#div-login').css('display','block');
	$('#div-recuperar').css('display','none');
})

$('#button-confirmacion').click(function(){

	var parametros= 
	"correo="+ corr+ "&"+
	"codigo="+ cod + "&"+
	"nueva_contraseña="+$("#recuperar-contraseña").val()
	
	console.log(parametros);

	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'Json',
		url:"../php/restablecer.php",
		success:function(resultado){
			let res = JSON.parse(resultado);
			console.log(resultado);
			if(res.hecho === true){
				$('#div-correcto').css('display','block');
				$('#div-contrasenia').css('display','none');			
			}else{
				console.log(resultado);
			}
		}
	});
});


/*
function Botones_activo(){
	$("#button-1").click(function(){
			$('#div-login').css('display','none');
			$('#div-recuperar').css('display','block');
	})

	$("#button-escribir").click(function(){
			$('#div-login').css('display','block');
			$('#div-recuperar').css('display','none');
	})

	$("#button-codigo").click(function(){
			$('#div-contrasenia').css('display','block');
			$('#div-recuperar').css('display','none');
	})
	$("#button-confirmacion").click(function(){
			$('#div-correcto').css('display','block');
			$('#div-contrasenia').css('display','none');
	})
}
*/