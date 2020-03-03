$(document).ready(function (){
    console.log("Carga JS!");
});



$('#button-create').click(function(){

	var parametros = 
	{
		c_dias : $("#create-dias").val(),
		c_noches :  $("#create-noches").val(),
		pais :$("#create-pais option:selected").val(),
		ciudad :$("#create-ciudad option:selected").val(),
		lugarTuristico : $("#create-lugarturistico option:selected").val(),
		guiaturismo : $("#create-guiaturismo option:selected").val(),
		precioruta : $("#create-precioRutas").val(),
		transporte : $("#create-transporte option:selected").val(),
		hotel :	$("#create-hotel option:selected").val()
	};
	
	console.log(parametros);

	$.ajax({
		type:"POST",
		data: parametros,
		datatype:'Json',
		url:"------------",
		success:function(resultado){
			console.log(resultado);
			let res = JSON.parse(resultado);
		
			if(res.signed === true){
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
