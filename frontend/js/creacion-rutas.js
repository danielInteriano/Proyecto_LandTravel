$(document).ready(function (){
    console.log("Carga JS!");
});

function getURLParameter(name) {
	return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

$('#button-create').click(function(){
	
	var parametros = 
	{
		c_dias : $("#create-dias").val(),
		c_noches :  $("#create-noches").val(),
		idtour : getURLParameter('id'),
		idlugar : $("#create-lugarturistico option:selected").val(),
		idguia : $("#create-guiaturismo option:selected").val(),
		precio : $("#create-precioRutas").val(),
		idtransporte : $("#create-transporte option:selected").val(),
		idpaquete :	$("#create-hotel option:selected").val()
	};
	
	console.log(parametros);

	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'Json',
		url:"../php/nuevaruta.php",
		success:function(resultado){
			console.log(resultado);
			let res = JSON.parse(resultado);
		
			if(res.creado === true){
				console.log("Si se creo");
				//$('#baba').prop('selectedIndex',0);
				//$('input[name=checkListItem').val('');			
			}else{
				alerty.error("No se creo");
			}
		}
	});
});






$("select#create-pais").change(function() {
 
$.ajax({
    type: 'POST',
    url: '../procesos/getCiudad-Pais.php',
    data: {id:$("#create-pais option:selected").val()},
    success: function(resp) {

                a= JSON.parse(resp);
                $("#create-ciudad").html("");
                $("#create-ciudad").append('<option value="" disabled selected hidden>-</option>');
                for(var i=0; i<=a.length-1; i++) {
                    $("#create-ciudad").append(`
                        <option value="${a[i][0]}">${a[i][2]}</option>
                        `);
                }
  }  
});
});


$("select#create-ciudad").change(function() {
$.ajax({
    type: 'POST',
    url: '../procesos/getLugTuris-Ciudad.php',
    data: {id:$("#create-ciudad option:selected").val()},
    success: function(resp) {
             
                a= JSON.parse(resp);
                $("#create-lugarturistico").html("");
                $("#create-lugarturistico").append('<option value="" disabled selected hidden>-</option>');
                for(var i=0; i<=a.length-1; i++) {
                    $("#create-lugarturistico").append(`
                        <option value="${a[i][0]}">${a[i][1]}</option>
                        `);
                }
  }  
});
});

$("select#create-ciudad").change(function() {
 
	$.ajax({
		type: 'POST',
		url: '../procesos/getHoteles-Ciudad.php',
		data: {id:$("#create-pais option:selected").val()},
		success: function(resp) {
					a= JSON.parse(resp);
					$("#create-hotel").html("");
					$("#create-hotel").append('<option value="" disabled selected hidden>-</option>');
					for(var i=0; i<=a.length-1; i++) {
						$("#create-hotel").append(`
							<option value="${a[i][0]}">${a[i][1]}</option>
							`);
					}
	  }  
	});
	});
