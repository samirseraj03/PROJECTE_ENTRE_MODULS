@extends('layouts.app')

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



@section('content')

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 linear-gradient_css">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form method="POST" id="cocacolaEspuma" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="correo" class="form-control" required autofocus>
                                <span class="error" id="emailError"></span>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="contrasenya" class="form-control" required>
                                <span class="error" id="passwordError"></span>
                            </div>

                            <button type="submit" id="loginBtn" class="btn btn-primary" id="loginBtn">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection