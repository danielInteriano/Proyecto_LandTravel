$(document).ready(function() {
	//alertify.success("¡Bienvenido!");
	console.log("Funciona JS");
})

$('#button-registrar').click(function(){

	var parametros = 
	{
		p_nombre : $("#primer-nombre").val(),
		s_nombre :  $("#segundo-nombre").val(),
		p_apellido : $("#primer-apellido").val(),
		s_apellido : $("#segundo-apellido").val(),
		correo : $("#registro-correo").val(),
		identidad : $("#registro-identidad").val(),
		confirmarcontraseña : $("#confirmar-contrasenia").val(),
		f_nacimiento : $("#registro-fechaNac").val(),
		contraseña : $("#registro-contrasenia").val(),
		idpais :$("#registro-pais option:selected").val()
	};
	
	if(parametros.confirmarcontraseña === parametros.contraseña)
	{
		console.log(parametros);

		$.ajax({
			type:"POST",
			data: parametros,
			datatype:'Json',
			url:"../php/signup.php",
			success:function(resultado){
				console.log(resultado);
				let res = JSON.parse(resultado);
			
				if(res.creado === true){
					location.href='index.php';					
				}else{
					alerty.error(res.mensaje);
				}
			}
		});
	}
});



