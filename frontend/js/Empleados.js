$(document).ready(function (){
	console.log("Carga JS!");
	$("#emp-pnombre").val("qwew");
});





$("select#select-empleado").change(function() {
	console.log($("#select-empleado option:selected").val());
$.ajax({
    type: 'POST',
    url: '../procesos/getDatos-Empleados.php',
    data: {id:$("#select-empleado option:selected").val()},
    success: function(resp) {
				a=JSON.parse(resp);
				console.log(a);
				$("#emp-pnombre").val(a[0][4]);
				$("#emp-snombre").val(a[0][5]);
				$("#emp-papellido").val(a[0][6]);
				$("#emp-sapellido").val(a[0][7]);
				$("#emp-fnac").val(a[0][9]);
				$("#emp-pais").val(a[0][13]);
				$("#emp-correo").val(a[0][8]);
				$("#emp-nacionalidad").val(a[0][14]);
				$("#emp-identidad").val(a[0][10]);
			
  }  
});
$.ajax({
	type: 'POST',
	url: '../procesos/getTable-Empleado.php',
	data: {id:$("#select-empleado option:selected").val()},
	success: function(resp) {
			 console.log(resp)
				a= JSON.parse(resp);
				$("#table-empleado").html("");
				for(var i=0; i<=a.length-1; i++) {
					$("#table-empleado").append(`
					<tr>
							<th scope="row">${a[0][22]}</th>
							<td>${a[i][23]}</td>
					</tr>`);
				}
  }  
});
});

