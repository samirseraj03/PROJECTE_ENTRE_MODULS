@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <form action="{{ route('new_survey') }}" method="POST">
        @csrf
        <div class="card text-center linear-gradient_css">
            <div class="card-body linear-gradient_css">
                <h5 class="card-title mb-4">Selecciona l'empresa amb la qual treballes</h5>
                <select id="selectEmpresa" name="id_empresa" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    <option value="" selected>Seleccionar empresa</option>
                    @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card text-center mt-5">
            <div class="card-body linear-gradient_css">
                <div class="mb-3">
                    <label for="nombreEncuesta" class="form-label">Descripció de l'enquesta</label>
                    <input type="text" class="form-control" id="nombreEncuesta" name="nombreEncuesta" placeholder="Nombre de la encuesta">
                </div>

                <label for="fechaFinalizacion" class="form-label">Data de finalizació</label>
                <div class="input-group input-group-lg mb-3">
                    <input type="date" class="form-control" name="fechaFinalizacion"  id="fechaFinalizacion" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>

                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-success d-flex align-items-start w-25 " data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                <p>¿Estás seguro de dar de alta?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
                                <button type="submit" class="btn btn-primary">Donar d'alta a l'enquesta</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>
</div>

@endsection