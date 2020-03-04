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



/*

$("#btn-publicar").click(function(){
    console.log($("#txtPub-modal").val());
    console.log($("#nombre").text());

    var parametros= 
    "nombre="+$("#nombre-lg").text()+
    "&"+"apellido="+$("#apellido").text()+
    "&"+"mensaje="+$("#txtPub-modal").val();

    console.log(parametros);
    
	$.ajax({
		url: "ajax/guardar-post-perfil.php",
		method: "POST",
		data: parametros,
		success:function(){
            console.log();
            console.log("Si guardo");
            $("#all-public").html("");
            cargarPostNoticias();
           
        },
		error: function(error){
           console.log(error);
		}
    });	
    
}); */
