   
   

   
   var token = $('meta[name="csrf-token"]').attr('content');
     console.log(token)
   $(document).ready(function() {
    // Agrega un evento change al select de empresas
    $('#selectEmpresa').change(function() {
        // Obtén el valor seleccionado
        var idEmpresa = $(this).val();

        // Construye la URL de la solicitud AJAX concatenando el ID de la empresa a la ruta
        var url = '/get-encuestas-por-empresa/' + idEmpresa;

        // Realiza una solicitud AJAX para obtener las encuestas de la empresa seleccionada
        $.ajax({
            url: url,
            method: 'GET', // Método HTTP
            headers: {
                'X-CSRF-TOKEN': token
            },
            success: function(response) {
                // Limpia el select de encuestas
                $('#selectEnquesta').empty();
                console.log(response)
                // Agrega las opciones de encuestas devueltas por el servidor al select de encuestas
                $.each(response, function(index, encuesta) {
                    $('#selectEnquesta').append($('<option>', {
                        value: encuesta.id_encuesta,
                        text: encuesta.descripcion
                    }));
                });
            },
            error: function(xhr, status, error) {
                // Maneja cualquier error que ocurra durante la solicitud AJAX
                console.error(error);
            }
        });
    });
});
