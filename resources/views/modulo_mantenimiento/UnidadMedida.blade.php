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
                        <h1 class="card-title">LISTA DE UNIDAD DE MEDIDAS</h1>
                        <div class="card-tools">
                            <!-- Mostrar botón solo si el usuario tiene permiso para crear -->
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
                                    <th>TIPO_REGISTRO</th>
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
                                @foreach ($UMedida as $Medida)
                                <tr>
                                    <th>{{$con=$con+1}}</th>
                                    <td>{{ $Medida["id_unidad_medida"] }}</td>
                                    <td>{{ $Medida["unidad_medida"] }}</td>
                                    <td>{{ $Medida["estado"] }}</td>
                                    <td>{{ $Medida["fecha_creacion"] }}</td>
                                    <td>{{ $Medida["creado_por"] }}</td>
                                    <td>{{ $Medida["fecha_modificacion"] }}</td>
                                    <td>{{ $Medida["modificado_por"] }}</td>
                                    <th>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <!-- Mostrar botón solo si el usuario tiene permiso para editar -->
                                            @if($permiso_edicion == 1)
                                            <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Medida['id_unidad_medida']}}">
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
@foreach ($UMedida as $Medida)
<div class="modal fade" id="modal-editor-{{$Medida['id_unidad_medida']}}">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">ACTUALIZAR UNIDAD DE MEDIDA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="editar_unimedida" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Medida['id_unidad_medida'] }}" required>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">UNIDAD MEDIDA</label>
                                <input type="text" id="unidad" name="unidad" class="form-control" value="{{ $Medida['unidad_medida'] }}" required>
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

<!-- AGREGAR -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">AGREGAR UNIDAD DE MEDIDA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_unimedida" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">UNIDAD MEDIDA</label>
                                <input type="text" id="unidad" name="unidad" class="form-control" required>
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