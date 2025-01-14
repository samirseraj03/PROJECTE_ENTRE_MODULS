@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="card text-center mt-5 linear-gradient_css">
        <div class="card-body">
            <form action="{{ route('submit-localitzacio') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombreEmpresa" class="form-label">Nom de la empresa</label>
                    <input type="text" class="form-control" id="nombreEmpresa" name="nombreEmpresa" placeholder="Nombre de la empresa">
                </div>
                <button type="submit" class="btn btn-secondary">Donar d'alta</button>
            </form>
        </div>
    </div>
</div>

@endsection