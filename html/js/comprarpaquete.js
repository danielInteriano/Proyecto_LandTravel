document.getElementById("botonComprar").addEventListener("click", function () {

    var numeroTarjeta = document.getElementById("numeroTarjeta").value;

    var esNumeroTarjetaValido = validarNumeroTarjeta(numeroTarjeta);


    var fecha = document.getElementById("fecha").value;

    var esFechaValida = validarFecha(fecha);

    var tourSeleccionado = $("#tour :selected").val();

    var esTourValido = validarTourValido(tourSeleccionado)

    console.log(esTourValido)

    var tipotour = $("#tipotour :selected").val();

    var estipotourvalido = validarTipoTour(tipotour);


    if (esNumeroTarjetaValido &&
        esFechaValida &&
        esTourValido &&
        estipotourvalido) {

            // $.ajax({
            //     url: "http://api.com",
            //     data: `tour=${tourSeleccionado}&fecha=${fecha}&numeroTarjeta=${numeroTarjeta}&tipoTour=${tipotour}`,
            //     method:"POST",
            //     success: function(respuesta){
            //         console.log(respuesta);

            //     },
            //     error: function(error){

            //     }
            // });
    } else {}
});


function validarTipoTour(tipotour) {

    if (tipotour == "null") {

        document.getElementById("tipotour").classList.remove("is-valid")

        document.getElementById("tipotour").classList.add("is-invalid")

        // $("#mensajetipotour").fadeIn();

        document.getElementById("mensajetipotour").style.display = "block";

        return false;

    } else {


        document.getElementById("tipotour").classList.remove("is-invalid")

        document.getElementById("tipotour").classList.add("is-valid")

        //$("#mensajetipotour").fadeOut();
        document.getElementById("mensajetipotour").style.display = "none";

        return true;
    }

}

function validarNumeroTarjeta(numeroTarjeta) {

    regexp = /^(?:(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/;


    if (regexp.test(numeroTarjeta)) {
        document.getElementById("numeroTarjeta").classList.remove("is-invalid")

        document.getElementById("numeroTarjeta").classList.add("is-valid")

        return true;
    } else {
        document.getElementById("numeroTarjeta").classList.add("is-valid")

        document.getElementById("numeroTarjeta").classList.add("is-invalid")

        return false;
    }
}

function validarFecha(fecha) {
    if (fecha != "") {

        document.getElementById("fecha").classList.remove("is-invalid")

        document.getElementById("fecha").classList.add("is-valid")

        $("#mensajeFecha").fadeOut();

        return true;
    } else {
        document.getElementById("fecha").classList.remove("is-valid")

        document.getElementById("fecha").classList.add("is-invalid")

        $("#mensajeFecha").fadeIn();

        return false;
    }
}

function validarTourValido(tourSeleccionado) {

    if (tourSeleccionado == "null") {

        document.getElementById("tour").classList.remove("is-valid")

        document.getElementById("tour").classList.add("is-invalid")

        // $("#mensajetour").fadeIn();

        document.getElementById("mensajetour").style.display = "block";

        return false;


    } else {


        document.getElementById("tour").classList.remove("is-invalid")

        document.getElementById("tour").classList.add("is-valid")

        //$("#mensajetour").fadeOut();
        document.getElementById("mensajetour").style.display = "none";

        return true;
    }
}


