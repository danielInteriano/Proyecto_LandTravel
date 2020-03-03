$(document).ready(function() {
	//alertify.success("¡Bienvenido!");
	console.log("Funciona JS");
})

$('#button-registrar').click(function(){

	var parametros = 
	{
		pnombre : $("#primer-nombre").val(),
		snombre :  $("#segundo-nombre").val(),
		papellido : $("#primer-apellido").val(),
		sapellido : $("#segundo-apellido").val(),
		correo : $("#registro-correo").val(),
		identidad : $("#registro-identidad").val(),
		confirmarContrasenia : $("#confirmar-contrasenia").val(),
		fechaNac : $("#registro-fechaNac").val(),
		contraseña : $("#registro-contrasenia").val(),
		pais :	$("#registro-pais option:selected").val()
	};
	
	console.log(parametros)
	;

	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'Json',
		url:"php/signup.php",
		success:function(resultado){
			console.log(resultado);
			let res = JSON.parse(resultado);
		
			if(res.signed === true){
				location.href='../login.php';					
			}else{
				alerty.error("No se pudo registrar");
			}
		}
	});
});



