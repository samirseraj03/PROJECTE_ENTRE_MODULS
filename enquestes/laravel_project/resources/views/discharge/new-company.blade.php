@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title mb-4">Seleccionar la empresa con la que estás trabajando</h5>
            <select id="selectEmpresa" class="form-select form-select-lg mb-3" aria-label="Large select example">
                <option value="" selected>Seleccionar empresa</option>
                @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card text-center mt-5">
        <div class="card-body">
            <form action="{{ route('submit-localitzacio') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombreEmpresa" class="form-label">Nombre de la empresa</label>
                    <input type="text" class="form-control" id="nombreEmpresa" name="nombreEmpresa" placeholder="Nombre de la empresa">
                </div>
        </div>
    </div>
</div>

@endsection