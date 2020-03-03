//validando campos vacios


function obteniendoid(id){
    const etiqueta=document.getElementById(id);
    if(etiqueta.value==''){
        etiqueta.classList.remove('inputvalido');
        etiqueta.classList.add('error');
    }
    else{
        etiqueta.classList.remove('error');
        etiqueta.classList.add('inputvalido');
    }
}

function valido(){
 obteniendoid('Identidad');
 obteniendoid('numerocontrato');
 obteniendoid('primernombre');
 obteniendoid('segundonombre');
 obteniendoid('primerapellido');
 obteniendoid('segundoapellido');
 obteniendoid('horastrabajo');

}

var btnguardarcambios=document.getElementById("btnguardarcambios");
btnguardarcambios.onclick=valido;

function obididentidad(id){
    const identidad=document.getElementById(id);
    if(identidad.value==''){
        identidad.classList.remove('inputvalido');
        identidad.classList.add('error');
    }
    else{
        identidad.classList.remove('error');
        identidad.classList.add('inputvalido');
    }


}


function v(){
    obididentidad('bi');
}


var btnbuscari=document.getElementById("btnbuscari");
btnbuscari.onclick=v;


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