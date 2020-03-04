$(document).ready(function (){
    console.log("Carga JS!");
});


$("select#inputEmpleado").change(function() {
 
    $.ajax({
        type: 'POST',
        url: '../procesos/getContrato-Empleado.php',
        data: {id:$("#inputEmpleado option:selected").val()},
        success: function(resp) {
    
                    a= JSON.parse(resp);
                    $("#vc-identidad").val(a[0][10]);
                    $("#vc-ncontrato").val(a[0][12]);
                    $("#vc-pnombre").val(a[0][4]);
                    $("#vc-snombre").val(a[0][5]);
                    $("#vc-papellido").val(a[0][6]);
                    $("#vc-sapellido").val(a[0][7]);
                    $("#inputContrato").append(`<option selected hidden>${a[0][21]}</option>`)

      }  
    });
    });