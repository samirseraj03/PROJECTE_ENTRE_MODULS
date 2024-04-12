@extends('layouts.app')

@section('content')



<div class="container mt-5">

    <form class="mx-5 px-5 d-flex" role="search">
        <input class="form-control me-2" id="search" type="search" placeholder="Search" aria-label="Search">
    </form>

</div>

<div class="container mt-5">

    <table id="tablaResultados" class="table table-dark table-sm mt-5">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Número de preguntes</th>
                <th scope="col">Estat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($arrayResultados as $key => $resultado)
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $resultado['nombre'] }}</td>
                <td>{{ $resultado['n_preguntas'] }}</td>
                <td>{{ $resultado['estado'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('document').ready(function() {

        $("#search").keyup(function() {
            var nombre = $(this).val().trim().toLowerCase();

            let arrayResultados = <?php echo json_encode($arrayResultados); ?>;
            let array_tmp = [...arrayResultados];

            if (nombre.length >= 2) {
                arrayResultados = filtrarPorNombre(nombre, arrayResultados)
                actualizarTabla(arrayResultados);
            } else {
                actualizarTabla(array_tmp);
            }


        });

        // Función para actualizar la tabla con los resultados filtrados
        function actualizarTabla(resultados) {
            var tbody = $('#tablaResultados tbody');
            tbody.empty();

            resultados.forEach(function(resultado, index) {
                var row = '<tr>' +
                    '<th scope="row">' + (index + 1) + '</th>' +
                    '<td>' + resultado.nombre + '</td>' +
                    '<td>' + resultado.n_preguntas + '</td>' +
                    '<td>' + resultado.estado + '</td>' +
                    '</tr>';

                tbody.append(row);
            });
        }

        function filtrarPorNombre(nombre, array) {
            return array.filter(function(resultado) {
                return resultado.nombre.toLowerCase().includes(nombre.toLowerCase());
            });
        }

    })
</script>





@endsection