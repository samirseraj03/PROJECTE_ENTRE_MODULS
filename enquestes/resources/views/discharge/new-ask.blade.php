@extends('layouts.app')

@section('content')

@if(session('error'))
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
    </div>
    <script>
        // Cerrar automáticamente el mensaje después de 5 segundos
        setTimeout(function() {
            document.getElementById('errorAlert').style.display = 'none';
        }, 5000);
    </script>
@endif

<div class="container mt-2">
    <form action="{{ route('new_ask') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <!-- seleccionar la empresa o la localitazio -->
                <div class="card text-center linear-gradient_css">
                    <div class="card-body">
                        <h5 class="card-title pb-3 mb-5">Seleccionar la empresa amb la que estás treballant</h5>
                        <select id="selectEmpresa" name="id_empresa" class="form-select form-select-lg mb-4 mt-1" aria-label="Large select example">
                            <option value="" selected>Seleccionar empresa</option>
                            @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <!-- selecionar la enquesta -->
                <div class="card text-center linear-gradient_css">
                    <div class="card-body">
                        <h5 class="card-title">Seleccionar la encuesta</h5>
                        <p class="card-text">Después de seleccionar la empresa, selecciona la encuesta que vols afegir per agregar la pregunta</p>
                        <select name="selectEncuesta" id="selectEncuesta" class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option value="" selected>Seleccionar encuesta</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <!-- la pregunta que es vol afegir  -->
        <div class="card text-center mt-5 linear-gradient_css" id="selectTipus" >
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombrePregunta" class="form-label">Descripció de la pregunta</label>
                    <input type="text" class="form-control" id="nombreEncuesta" name="nombrePregunta" placeholder="Nombre de la pregunta">
                </div>

                <label for="TipusPregutnta" class="form-label">Tipus de Pregunta</label>
                <select name="selectTipusPregunta" id="selectTipusPregunta" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    <option  value="" selected>Seleccionar opció</option>
                    @foreach ($tipus as $tipus_pregunta)
                    <option value="{{ $tipus_pregunta->id_tipus }}">{{ $tipus_pregunta->tipus }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row" id="selectAdicional" style="display: none;">
                <div class="col">
                    <div class="card-body">
                        <label for="TipusPregutnta" class="form-label">Selecciona les opcions que vols afegir</label>
                        <select id="selectOpcion" class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option value="" selected>Seleccionar opció</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="card-body">
                        <label for="TipusPregutnta" class="form-label">Les opcions que s'han afegit</label>
                        <div class="row" id="opcionsAfegides"></div>
                        <input type="hidden" name="opcionsSeleccionades" id="opcionsSeleccionades">
                    </div>
                </div>
            </div>
        </div>


        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-success d-flex align-items-start w-25 mt-2 " data-bs-toggle="modal" data-bs-target="#exampleModal">
            <span class="text-center">Donar d'alta</span>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Donar d'alta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de voler donar d'alta?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
                        <button type="submit" class="btn btn-primary">Donar d'alta la pregunta</button>
                    </div>
                </div>
            </div>
        </div>

</div>
</div>

</form>
<script>
    $(document).ready(function() {
        $("#selectOpcion").change(function() {
            var textoSeleccionado = $(this).find("option:selected").text();
            var valueTextoSeleccionado = $(this).find("option:selected").value;
            $("#opcionsAfegides").append(`<p id=${valueTextoSeleccionado} >` + textoSeleccionado + "</p>");
        });
    });
</script>

<script>

$(document).ready(function() {
  $("#selectOpcion").change(function() {
    var textoSeleccionado = $(this).find("option:selected").text();
    var valorSeleccionado = $(this).val(); // Obtener el valor real


    // Actualizar el campo de entrada oculto con los valores seleccionados
    var valoresActuales = $("#opcionsSeleccionades").val() || ""; // Manejar estado inicial vacío
    $("#opcionsSeleccionades").val(valoresActuales + valorSeleccionado + ",");
  });
});



</script>




<!-- per recuperar totes les enquestas quan es selecciona la empresa -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var token = $('meta[name="csrf-token"]').attr('content');
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
                    $('#selectEncuesta').empty();
                    // Agrega las opciones de encuestas devueltas por el servidor al select de encuestas
                    $.each(response, function(index, encuesta) {

                        $('#selectEncuesta').append($('<option>', {
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
</script>


<script>
    var token = $('meta[name="csrf-token"]').attr('content');
    console.log(token)

    $(document).ready(function() {
        $('#selectTipusPregunta').change(function() {
            var selectedValue = $(this).val();

            // buscamos si el value es select
            if (selectedValue === '4' || selectedValue === '5') {
                $("#selectAdicional").css("display", "block");


                // Construye la URL de la solicitud AJAX concatenando el ID de la empresa a la ruta
                var url = '/getopciones';

                // llamamos a la base de datos para devolver algo nuevo
                $.ajax({
                    url: url,
                    method: 'GET', // Método HTTP
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        // Limpia el select de encuestas
                        $('#selectOpcion').empty();
                        console.log(response)
                        // Agrega las opciones de encuestas devueltas por el servidor al select de encuestas
                        $.each(response, function(index, encuesta) {
                            $('#selectOpcion').append($('<option>', {
                                value: encuesta.id_opcion,
                                text: encuesta.descripcion
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        // Maneja cualquier error que ocurra durante la solicitud AJAX
                        console.error(error);
                    }
                });
            } else {
                $("#selectAdicional").css("display", "none");
                $("opcionsAfegides").empty()

            }
        });
    });
</script>

</div>

@endsection