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






$("select#rt-nombretour").change(function() {
 
$.ajax({
    type: 'POST',
    url: '../procesos/getTour-RT.php',
    data: {id:$("#rt-nombretour option:selected").val()},
    success: function(resp) {

                a= JSON.parse(resp);
				$("#table-body-1").html("");
				for(var i=0; i<=a.length-1; i++) {
                $("#table-body-1").append(`<tr>
                        <td>${a[i][3]}</td>
                        <td>${a[i][2]}</td>
                        <td>${a[i][3]}</td>
                        <td>${a[i][5]}</td>
                      </tr>`);
				}
				
  }  
});
});
