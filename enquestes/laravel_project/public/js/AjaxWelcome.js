var token = $('meta[name="csrf-token"]').attr('content');
console.log(token)
$(document).ready(function () {
    // Agrega un evento change al select de empresas
    $("#selectEmpresa_enquesta").change(function () {
        // Obtén el valor seleccionado
        var idEmpresa = $(this).val();

        // Construye la URL de la solicitud AJAX concatenando el ID de la empresa a la ruta
        var url = "/countEnquestas";

        // Realiza una solicitud AJAX para obtener las encuestas de la empresa seleccionada
        $.ajax({
            url: url,
            method: "GET", // Método HTTP
            headers: {
                "X-CSRF-TOKEN": token || "",
            },
            data: {
                idEmpresa: idEmpresa,
            },
            success: function (response) {
                // Limpia el select de encuestas
                $("#contador_enquestas").empty();
                console.log(response);
                // Agrega las opciones de encuestas devueltas por el servidor al select de encuestas
                var contadorPreguntas = $("#contador_enquestas");
                // Añadir texto al elemento <p>
                contadorPreguntas.text(`#${response}`);
            },
            error: function (xhr, status, error) {
                // Maneja cualquier error que ocurra durante la solicitud AJAX
                console.error(error);
            },
        });
    });



    $("#selectEmpresaPreguntas").change(function () {
        // Obtén el valor seleccionado
        var idEmpresa = $(this).val();

        // Construye la URL de la solicitud AJAX concatenando el ID de la empresa a la ruta
        var url = "/countPreguntas";

        // Realiza una solicitud AJAX para obtener las encuestas de la empresa seleccionada
        $.ajax({
            url: url,
            method: "GET", // Método HTTP
            headers: {
                "X-CSRF-TOKEN": token || "",
            },
            data: {
                idEmpresa: idEmpresa,
            },
            success: function (response) {
                // Limpia el select de encuestas
                $("#contador_preguntas").empty();
                console.log(response);
                // Agrega las opciones de encuestas devueltas por el servidor al select de encuestas
                var contadorPreguntas = $("#contador_preguntas");
                // Añadir texto al elemento <p>
                contadorPreguntas.text(`#${response}`);
            },
            error: function (xhr, status, error) {
                // Maneja cualquier error que ocurra durante la solicitud AJAX
                console.error(error);
            },
        });
    });


    $("#contador_preguntas_usuari").ready(function () {
        // Construye la URL de la solicitud AJAX concatenando el ID de la empresa a la ruta
        var url = "/countUsuariContestat";

        // Realiza una solicitud AJAX para obtener las encuestas de la empresa seleccionada
        $.ajax({
            url: url,
            method: "GET", // Método HTTP
            headers: {
                "X-CSRF-TOKEN": token || "",
            },
            success: function (response) {
                // Limpia el select de encuestas
                $("#contador_preguntas_usuari").empty();
                console.log(response);
                // Agrega las opciones de encuestas devueltas por el servidor al select de encuestas
                var contadorPreguntas = $("#contador_preguntas_usuari");
                // Añadir texto al elemento <p>
                contadorPreguntas.text(`#${response}`);
            },
            error: function (xhr, status, error) {
                // Maneja cualquier error que ocurra durante la solicitud AJAX
                console.error(error);
            },
        });
    });





});
