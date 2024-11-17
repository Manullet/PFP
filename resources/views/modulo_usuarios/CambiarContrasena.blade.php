@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cambiar Contraseña</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('cambiar-contrasena.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="contrasena_actual">Contraseña Actual</label>
            <input type="password" name="contrasena_actual" id="contrasena_actual" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nueva_contrasena">Nueva Contraseña</label>
            <input type="password" name="nueva_contrasena" id="nueva_contrasena" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="confirmar_contrasena">Confirmar Nueva Contraseña</label>
            <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
    </form>
</div>
@endsection
