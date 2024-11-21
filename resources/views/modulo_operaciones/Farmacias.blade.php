@extends('layouts.principal')

@section('content')
<div class="container-fluid py-4">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Tarjeta -->
                    <div class="card">
                        <!-- Tarjeta Cabeza -->
                        <div class="card-header">
                            <h1 class="card-title">LISTA DE FARMACIAS</h1>
                            <div class="card-tools">
                                <!-- Mostrar botón solo si el usuario tiene permiso de inserción -->
                                @if ($permiso_insercion == 1)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+NUEVO</button>
                                @endif
                                <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
                            </div>
                        </div>

                        <!-- /.INICIO DE LA TABLA -->
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover table-sm text-center">
                                <thead class="bg-danger text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>RTN FARMACIA</th>
                                        <th>NOMBRE FARMACIA</th>
                                        <th>SUCURSAL</th>
                                        <th>USUARIO</th>
                                        <th>ENTIDAD</th>
                                        <th>ESTADO</th>
                                        <th>CONTACTO</th>
                                        <th>FECHA CREACION</th>
                                        <th>CREADO POR</th>
                                        <th>FECHA MODIFICACION</th>
                                        <th>MODIFICADO POR</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Farmacias as $Farmacia)
                                        <tr>
                                            <td>{{ $Farmacia['id_farmacia'] }}</td>
                                            <td>{{ $Farmacia['rtn_farmacia'] }}</td>
                                            <td>{{ $Farmacia['nombre_farmacia'] }}</td>
                                            <td>{{ $Farmacia['nombre_sucursal'] }}</td>
                                            <td>{{ $Farmacia['nombre_usuario'] }}</td>
                                            <td>{{ $Farmacia['tipo_entidad'] }}</td>
                                            <td>{{ $Farmacia['estado'] }}</td>
                                            <td>{{ $Farmacia['nombre_contacto'] }}</td>
                                            <td>{{ $Farmacia['fecha_creacion'] }}</td>
                                            <td>{{ $Farmacia['creado_por'] }}</td>
                                            <td>{{ $Farmacia['fecha_modificacion'] }}</td>
                                            <td>{{ $Farmacia['modificado_por'] }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- Mostrar botón solo si el usuario tiene permiso de edición -->
                                                    @if($permiso_edicion == 1)
                                                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Farmacia['id_farmacia']}}">
                                                            <i class="bi bi-pencil-fill"></i> ACTUALIZAR
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- FIN de la tabla -->
                    </div>
                    <!-- FIN de la tarjeta -->
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL EDITAR -->
@foreach ($Farmacias as $Farmacia)
<div class="modal fade" id="modal-editor-{{$Farmacia['id_farmacia']}}">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">ACTUALIZAR FARMACIA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="editar_farmacia" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Farmacia['id_farmacia']}}" required>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rtn">RTN</label>
                                <input type="text" id="rtn" name="rtn" class="form-control" value="{{ $Farmacia['rtn_farmacia'] }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">FARMACIA</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $Farmacia['nombre_farmacia'] }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sucursal">SUCURSAL</label>
                                <select id="sucursal" name="sucursal" class="form-control" required>
                                    @foreach ($tblsucursal as $tbl)
                                    <option value="{{ $tbl['id_sucursal'] }}" {{ $Farmacia['id_sucursal'] == $tbl['id_sucursal'] ? 'selected' : '' }}>{{ $tbl["nombre_sucursal"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario">USUARIO</label>
                                <select id="usuario" name="usuario" class="form-control" required>
                                    @foreach ($tblusuario as $tbl)
                                    <option value="{{ $tbl['id_usuario'] }}" {{ $Farmacia['id_usuario'] == $tbl['id_usuario'] ? 'selected' : '' }}>{{ $tbl["nombre_usuario"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="entidad">ENTIDAD</label>
                                <select id="entidad" name="entidad" class="form-control" required>
                                    @foreach ($tblentidad as $tbl)
                                    <option value="{{ $tbl['id_tipo_entidad'] }}" {{ $Farmacia['id_tipo_entidad'] == $tbl['id_tipo_entidad'] ? 'selected' : '' }}>{{ $tbl["tipo_entidad"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado">ESTADO</label>
                                <select id="estado" name="estado" class="form-control" required>
                                    @foreach ($tblestado as $tbl)
                                    <option value="{{ $tbl['id_estado'] }}" {{ $Farmacia['id_estado'] == $tbl['id_estado'] ? 'selected' : '' }}>{{ $tbl["estado"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contacto">CONTACTO</label>
                                <select id="contacto" name="contacto" class="form-control" required>
                                    @foreach ($tblcontacto as $tbl)
                                    <option value="{{ $tbl['id_contacto'] }}" {{ $Farmacia['id_contacto'] == $tbl['id_contacto'] ? 'selected' : '' }}>{{ $tbl["nombre_contacto"] }}</option>
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

<!-- AGREGAR FARMACIA -->


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">AGREGAR UNA NUEVA FARMACIA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_farmacia" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rtn">RTN</label>
                                <input type="text" id="rtn" name="rtn" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">FARMACIA</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sucursal">SUCURSAL</label>
                                <select id="sucursal" name="sucursal" class="form-control" required>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblsucursal as $tbl)
                                    <option value="{{ $tbl['id_sucursal'] }}">{{ $tbl["nombre_sucursal"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario">USUARIO</label>
                                <select id="usuario" name="usuario" class="form-control" required>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblusuario as $tbl)
                                    <option value="{{ $tbl['id_usuario'] }}">{{ $tbl["nombre_usuario"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="entidad">ENTIDAD</label>
                                <select id="entidad" name="entidad" class="form-control" required>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblentidad as $tbl)
                                    <option value="{{ $tbl['id_tipo_entidad'] }}">{{ $tbl["tipo_entidad"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado">ESTADO</label>
                                <select id="estado" name="estado" class="form-control" required>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblestado as $tbl)
                                    <option value="{{ $tbl['id_estado'] }}">{{ $tbl["estado"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contacto">CONTACTO</label>
                                <select id="contacto" name="contacto" class="form-control" required>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblcontacto as $tbl)
                                    <option value="{{ $tbl['id_contacto'] }}">{{ $tbl["nombre_contacto"] }}</option>
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
