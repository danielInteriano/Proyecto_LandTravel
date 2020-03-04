$(document).ready(function() {
	//alertify.success("¡Bienvenido!");
	console.log("Funciona JS");
	alertify.success('Bienvenido');
})

$('#iniciar-sesion').click(function(){

	var parametros = {
		'usuario': $("#login-usuario").val(),
		'contrasenia': $("#login-contraseña").val(),
	};
	console.log(parametros)
	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'json',
		url:"../php/login.php",
		success:function(resultado){
			console.log(resultado);
			if(resultado==true){
				location.href='Tours.php';					
			}else{
				console.log("no se pudo registrar");
				alertify.error('No concuerdan los datos');
			}
		}
	});
});
