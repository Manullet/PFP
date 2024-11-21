@extends ('layouts.principal')
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
                        @if(session()->has('usuario'))
                            <p>Usuario autenticado: {{ session('usuario')['nombre_usuario'] }}</p>
                            <p>Rol: {{ session('usuario')['id_rol'] }}</p>
                        @else
                            <p>No se encontró un usuario autenticado en la sesión.</p>
                        @endif

                        <!-- Mostrar permisos -->
                        <p>Permiso de Inserción: {{ $permiso_insercion }}</p>
                        <p>Permiso de Actualización: {{ $permiso_edicion }}</p>
                        

                        <h1 class="card-title">LISTA DE USUARIOS</h1>
                        <div class="card-tools">
                            @if ($permiso_insercion == 1)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+ NUEVO</button>
                            @endif  <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
                            </div>
                        </div>
       
                        <!-- /.INICIO DE LA TABLA -->
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover table-sm text-center">
                                <thead class="bg-danger text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>MARCA</th>
                                        <th>ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th>CREADO_POR</th>
                                        <th>FECHA_MODIFICACION</th>
                                        <th>MODIFICADO_POR</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Marcas as $Marca)
                                        <tr>
                                            <td>{{ $Marca['id_marca_producto'] }}</td>
                                            <td>{{ $Marca['marca_producto'] }}</td>
                                            <td>{{ $Marca['estado'] }}</td>
                                            <td>{{ $Marca['fecha_creacion'] }}</td>
                                            <td>{{ $Marca['creado_por'] }}</td>
                                            <td>{{ $Marca['fecha_modificacion'] }}</td>
                                            <td>{{ $Marca['modificado_por'] }}</td>
                                            <th>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- Mostrar botón solo si el usuario tiene permiso para editar -->
                                                    @if($permiso_edicion == 1)
                                                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Marca['id_marca_producto']}}">
                                                            <i class="bi bi-pencil-fill"></i> ACTUALIZAR 
                                                        </a>
                                                    @endif
                                                </div>
                                            </th>
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

<!--MODAL EDITAR-->
@foreach ($Marcas as $Marca)
<div class="modal fade" id="modal-editor-{{$Marca['id_marca_producto']}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ACTUALIZAR MARCA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="editar_marca" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Marca['id_marca_producto']}}" required>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">MARCA</label>
                            <input type="text" id="marca" name="marca" class="form-control" value="{{$Marca['marca_producto']}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ESTADO</label>
                            <select id="estdo" name="estdo" class="form-control" required>
                                @foreach ($tblestado as $tbl)
                                    <option value="{{ $tbl['id_estado']}}">{{$tbl["estado"]}}</option>
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

<!--AGREGAR MARCA-->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">AGREGAR UN NUEVO LABORATORIO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_marca" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">NOMBRE_Marca</label>
                            <input type="text" id="marca" name="marca" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ESTADO</label>
                            <select id="estdo" name="estdo" class="form-control" required>
                                <option>SELECCIONA</option>
                                @foreach ($tblestado as $tbl)
                                    <option value="{{ $tbl['id_estado']}}">{{$tbl["estado"]}}</option>
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
