@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <form action="{{ route('new_ask') }}" method="POST">
        @csrf

        <!-- seleccionar la empresa o la localitazio -->
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title mb-4">Seleccionar la empresa con la que estás trabajando</h5>
                <select id="selectEmpresa" name="id_empresa" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    <option value="" selected>Seleccionar empresa</option>
                    @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <!-- selecionar la enquesta -->
        <div class="card text-center mt-5">
            <div class="card-body">
                <h5 class="card-title">Seleccionar la encuesta</h5>
                <p class="card-text">Después de seleccionar la empresa, selecciona la encuesta que quieres agregar para agregar la pregunta</p>
                <select id="selectEncuesta" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    <option value="" selected>Seleccionar encuesta</option>
                </select>
            </div>
        </div>



        <!-- la pregunta que es vol afegir  -->
        <div class="card text-center mt-5">
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombrePregunta" class="form-label">Descripción de la pregutna</label>
                    <input type="text" class="form-control" id="nombreEncuesta" name="nombrePregunta" placeholder="Nombre de la pregunta">
                </div>

                <label for="TipusPregutnta" class="form-label">Tipus de Pregunta</label>
                <div class="input-group input-group-lg mb-3">
                    <input type="date" class="form-control" name="TipusPregutnta" id="TipusPregutnta" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>

                <select id="selectEncuesta" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    <option value="" selected>Seleccionar opcio</option>
                    @foreach ($tipus_pregunta as $tipus)
                    <option value="{{ $tipus_pregunta->id_tipus }}">{{ $tipus_pregunta->tipus }}</option>
                    @endforeach
                </select>


     



    </form>


               <!-- Botón para abrir el modal -->
               <!-- <button type="button" class="btn btn-success d-flex align-items-start w-25 " data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <span class="text-center">Dar De alta</span>
                </button> -->

                <!-- Modal -->
                <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Donar d'alta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de dar de alta?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Dar alta a la pregunta</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> -->




    <!-- per recuperar totes les enquestas quan es selecciona la empresa -->

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
                        $('#selectEncuesta').empty();
                        console.log(response)
                        // Agrega las opciones de encuestas devueltas por el servidor al select de encuestas
                        $.each(response, function(index, encuesta) {
                            $('#selectEncuesta').append($('<option>', {
                                value: encuesta.id,
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





</div>

@endsection