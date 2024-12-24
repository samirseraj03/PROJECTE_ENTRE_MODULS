@extends('layouts.app')

@section('content')



@if(session('error'))
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
    </div>
    <script>
        //Cerrar automáticamente el mensaje después de 5 segundos
        setTimeout(function() {
            document.getElementById('errorAlert').style.display = 'none';
        }, 5000);
    </script>
@endif

<div class="container mt-5 ">
    <form action="{{ route('enquesta') }}" method="GET">
        <div class="card text-center linear-gradient_css">
            <div class="card-body">
                <h5 class="card-title mb-4">Selecciona l'empresa amb la qual estàs treballant</h5>
                <select id="selectEmpresa" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    <option value="" selected>Seleccionar empresa</option>
                    @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card text-center mt-5">
            <div class="card-body linear-gradient_css">
                <h5 class="card-title">Seleccionar l'enquesta</h5>
                <p class="card-text">Després de seleccionar l'empresa, selecciona l'enquesta que vols respondre</p>
                <select id="selectEnquesta" name="selectEnquesta" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    <option value="" selected>Seleccionar enquesta</option>
                </select>
                <button id="getSurvey" type="submit" class="btn btn-primary">Respondre l'enquesta</button>
            </div>
        </div>
    </form>
</div>

<script>
    // JavaScript
    document.getElementById("selectEnquesta").addEventListener("change", function() {
        // Obtener el valor seleccionado del select
        var valorSeleccionado = this.value;

        // Obtener el botón por su ID
        var boton = document.getElementById("getSurvey");

        // Habilitar el botón si se ha seleccionado una opción
        if (valorSeleccionado !== "") {
            boton.disabled = false;
        } else {
            // Si no se ha seleccionado ninguna opción, deshabilitar el botón
            boton.disabled = true;
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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


                    if (Array.isArray(response) && response.length == 0) {

                        var boton = document.getElementById("getSurvey");
                        boton.disabled = true;
                        alert("posa al menys una enquesta a la empresa")

                    }

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
</script>

@endsection