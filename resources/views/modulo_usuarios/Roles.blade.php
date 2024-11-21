@extends ('layouts.principal')
@section('content')

<br>
<div value="{{ $con = 0 }}"></div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Tarjeta -->
                <div class="card">
                    <!-- Tarjeta_CABEZA -->
                    <div class="card-header">
                        <!-- Depuración: Mostrar datos del usuario autenticado y sus permisos -->
                        @if(session()->has('usuario'))
                            <p>Usuario autenticado: {{ session('usuario')['nombre_usuario'] }}</p>
                            <p>Rol: {{ session('usuario')['id_rol'] }}</p>
                        @else
                            <p>No se encontró un usuario autenticado en la sesión.</p>
                        @endif

                        <!-- Mostrar permisos -->
                        <p>Permiso de Inserción: {{ $permiso_insercion }}</p>
                        <p>Permiso de Actualización: {{ $permiso_actualizacion }}</p>
                        <p>Permiso de Eliminación: {{ $permiso_eliminacion }}</p>

                        <h1 class="card-title">LISTA DE ROLES</h1>
                        <div class="card-tools">
                            @if ($permiso_insercion == 1)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+ NUEVO</button>
                            @endif
                            <a href="{{ url('') }}" class="btn btn-secondary">VOLVER</a>
                        </div>
                    </div>

                    <div class="card-body"> <!-- Tarjeta_BODY -->
                        <!-- Tabla -->
                        <table id="example1" class="table table-bordered table-striped">
                            <!-- Tabla_CABEZA -->
                            <thead class="text-center bg-danger blue text-white">
                                <tr>
                                    <th>n°</th>
                                    <th>CODIGO</th>
                                    <th>ROL</th>
                                    <th>DESCRIPCION</th>
                                    <th>FECHA_CREACION</th>
                                    <th>CREADO_POR</th>
                                    <th>FECHA_MODIFICACION</th>
                                    <th>MODIFICADO_POR</th>
                                    <th>ESTADO</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <!-- Tabla_BODY -->
                            <tbody>
                                @foreach ($Roles as $Rol)
                                    <tr>
                                        <th>{{ $con = $con + 1 }}</th>
                                        <td>{{ $Rol['id_rol'] }}</td>
                                        <td>{{ $Rol['rol'] }}</td>
                                        <td>{{ $Rol['descripcion'] }}</td>
                                        <td>{{ $Rol['fecha_creacion'] }}</td>
                                        <td>{{ $Rol['creado_por'] }}</td>
                                        <td>{{ $Rol['fecha_modificacion'] }}</td>
                                        <td>{{ $Rol['modificado_por'] }}</td>
                                        <td>{{ $Rol['id_estado'] }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @if ($permiso_actualizacion == 1)
                                                    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{ $Rol['id_rol'] }}">
                                                        <i class="bi bi-pencil-fill"></i> ACTUALIZAR
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- FIN_Tabla -->
                    </div>
                </div>
                <!-- FIN_Tarjeta -->
            </div>
        </div>
    </div>
</section>

<!-- MODAL EDITAR -->
@foreach ($Roles as $Rol)
<div class="modal fade" id="modal-editor-{{ $Rol['id_rol'] }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">ACTUALIZAR ROL</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="editar_rol" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Rol['id_rol'] }}" required>

                    <div class="form-group">
                        <label for="rol">ROL</label>
                        <input type="text" id="rol" name="rol" class="form-control" value="{{ $Rol['rol'] }}" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">DESCRIPCION</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control" value="{{ $Rol['descripcion'] }}" required>
                    </div>

                    <div class="form-group">
                        <label for="estdo">ESTADO</label>
                        <select id="estdo" name="estdo" class="form-control" required>
                            @foreach ($tblestado as $tbl)
                                <option value="{{ $tbl['id_estado'] }}">{{ $tbl['estado'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach

<!-- MODAL NUEVO -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">AGREGAR UN NUEVO ROL</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_rol" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rol">ROL</label>
                        <input type="text" id="rol" name="rol" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">DESCRIPCION</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="estdo">ESTADO</label>
                        <select id="estdo" name="estdo" class="form-control" required>
                            <option value="">SELECCIONA</option>
                            @foreach ($tblestado as $tbl)
                                <option value="{{ $tbl['id_estado'] }}">{{ $tbl['estado'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-primary">AGREGAR</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
