$(document).ready(function() {
	//alertify.success("¡Bienvenido!");
	console.log("Funciona JS");
	alertify.success('Bienvenido');
})

$('.eliminar').click(function(){
	$.ajax({
		type:"DELETE",
		datatype:'Json',
		url:"../php/eliminarTour.php",
		success:function(resultado){
			console.log(resultado);
			let res = JSON.parse(resultado);
		
			if(res.hecho === true){
				location.reload();
				//$('#baba').prop('selectedIndex',0);
				//$('input[name=checkListItem').val('');			
			}else{
				alert("Hubo un error");
			}
		}
	});
});
