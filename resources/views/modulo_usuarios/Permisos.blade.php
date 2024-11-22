@extends('layouts.principal')

@section('content')
<br>

<!-- Contenedor principal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Tarjeta -->
            <div class="card">
                <!-- Encabezado de la tarjeta -->
                <div class="card-header">
                    <h1 class="card-title">LISTA DE PERMISOS</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-agregar">
                            <i class="fas fa-plus"></i> NUEVO
                        </button>
                    </div>
                </div>
                
                <!-- Cuerpo de la tarjeta -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <!-- Encabezado de la tabla -->
                        <thead class="text-center bg-danger text-white">
                            <tr>
                                <th>CODIGO</th>
                                <th>ROL</th>
                                <th>OBJETO</th>
                                <th>PERMISO CREACION</th>
                                <th>PERMISO ACTUALIZACION</th>
                                <th>PERMISO ELIMINACION</th>
                                <th>PERMISO CONSULTAR</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)
                                <tr>
                                    <td>{{ $permiso->codigo }}</td>
                                    <td>{{ $permiso->rol }}</td>
                                    <td>{{ $permiso->objeto }}</td>
                                    <td>{{ $permiso->permiso_creacion ? '1' : '0' }}</td>
                                    <td>{{ $permiso->permiso_actualizacion ? '1' : '0' }}</td>
                                    <td>{{ $permiso->permiso_eliminacion ? '1' : '0' }}</td>
                                    <td>{{ $permiso->permiso_consultar ? '1' : '0' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-editar-{{ $permiso->codigo }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin tarjeta -->
        </div>
    </div>
</div>

<!-- Modal: Agregar Permiso -->
<div class="modal fade" id="modal-agregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">AGREGAR PERMISO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('permisos.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rol">ROL</label>
                        <select id="rol" name="rol" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="objeto">OBJETO</label>
                        <input type="text" id="objeto" name="objeto" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="permiso_creacion">PERMISO CREACION</label>
                        <input type="checkbox" id="permiso_creacion" name="permiso_creacion" value="1">
                    </div>
                    <div class="form-group">
                        <label for="permiso_actualizacion">PERMISO ACTUALIZACION</label>
                        <input type="checkbox" id="permiso_actualizacion" name="permiso_actualizacion" value="1">
                    </div>
                    <div class="form-group">
                        <label for="permiso_eliminacion">PERMISO ELIMINACION</label>
                        <input type="checkbox" id="permiso_eliminacion" name="permiso_eliminacion" value="1">
                    </div>
                    <div class="form-group">
                        <label for="permiso_consultar">PERMISO CONSULTAR</label>
                        <input type="checkbox" id="permiso_consultar" name="permiso_consultar" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modales: Editar Permisos -->
@foreach ($permisos as $permiso)
<div class="modal fade" id="modal-editar-{{ $permiso->codigo }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EDITAR PERMISO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('permisos.update', $permiso->codigo) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Campos similares al modal de agregar -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
