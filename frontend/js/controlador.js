$(document).ready(function() {
	//alertify.success("¡Bienvenido!");
	console.log("Funciona JS");
	alertify.success('Bienvenido');
})

$('#iniciar-sesion').click(function(){

	var parametros = {
		'usuario': $("#login-usuario").val(),
		'contraseña': $("#login-contraseña").val(),
	};
	
	console.log(parametros)
	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'json',
		url:"../php/login.php",
		success:function(resultado){
			retorno = JSON.parse(resultado);
			if(retorno.logged){
				location.href='Tours.php';					
			}else{
				alertify.error(retorno.mensaje);
			}
		}
	});
});
