@extends ('layouts.principal')
@section('content')

<br>
<div value="{{$con=0}}"></div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Tarjeta -->
                <div class="card">
                    <!-- Tarjeta Cabeza -->
                    <div class="card-header">
                        <h1 class="card-title">LISTA DE ESPECIALIDADES</h1>
                        <div class="card-tools">
                            <!-- Botón NUEVO condicionado a permiso de inserción -->
                            @if($permiso_insercion == 1)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+NUEVO</button>
                            @endif
                            <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
                        </div>
                    </div>

                    <div class="card-body"> <!-- Tarjeta Body -->
                        <!-- Tabla -->
                        <table id="example1" class="table table-bordered table-striped">
                            <!-- Tabla Cabeza -->
                            <thead class="text-center bg-danger blue text-white">
                                <tr>
                                    <th>n°</th>
                                    <th>CODIGO</th>
                                    <th>NOMBRE_ESPECIALIDAD</th>
                                    <th>ESTADO</th>
                                    <th>FECHA_CREACION</th>
                                    <th>CREADO_POR</th>
                                    <th>FECHA_MODIFICACION</th>
                                    <th>MODIFICADO_POR</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <!-- Tabla Body -->
                            <tbody>
                                @foreach ($Especialidades as $Especialidad)
                                    <tr>
                                        <th>{{$con=$con+1}}</th>
                                        <td>{{ $Especialidad["id_especialidad"] }}</td>
                                        <td>{{ $Especialidad["nombre_especialidad"] }}</td>
                                        <td>{{ $Especialidad["estado"] }}</td>
                                        <td>{{ $Especialidad["fecha_creacion"] }}</td>
                                        <td>{{ $Especialidad["creado_por"] }}</td>
                                        <td>{{ $Especialidad["fecha_modificacion"] }}</td>
                                        <td>{{ $Especialidad["modificado_por"] }}</td>
                                        <th>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <!-- Botón ACTUALIZAR condicionado a permiso de edición -->
                                                @if($permiso_edicion == 1)
                                                    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Especialidad['id_especialidad']}}">
                                                        <i class="bi bi-pencil-fill"></i> ACTUALIZAR
                                                    </a>
                                                @endif
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- FIN Tabla -->
                    </div>
                </div>
                <!-- FIN Tarjeta -->
            </div>
        </div>
    </div>
</section>

<!-- MODAL EDITAR -->
@foreach ($Especialidades as $Especialidad)
    <div class="modal fade" id="modal-editor-{{$Especialidad['id_especialidad']}}">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">ACTUALIZAR ESPECIALIDAD</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="editar_especialidad" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Especialidad['id_especialidad'] }}" required>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">NOMBRE_ESPECIALIDAD</label>
                                    <input type="text" id="especialidad" name="especialidad" class="form-control" value="{{ $Especialidad['nombre_especialidad'] }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">ESTADO</label>
                                    <select id="estdo" name="estdo" class="form-control" required>
                                        @foreach ($tblestado as $tbl)
                                            <option value="{{ $tbl['id_estado'] }}">{{ $tbl["estado"] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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

<!-- MODAL AGREGAR -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">AGREGAR UNA NUEVA ESPECIALIDAD</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_especialidad" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">NOMBRE_ESPECIALIDAD</label>
                                <input type="text" id="especialidad" name="especialidad" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">ESTADO</label>
                                <select id="estdo" name="estdo" class="form-control" required>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblestado as $tbl)
                                        <option value="{{ $tbl['id_estado'] }}">{{ $tbl["estado"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
