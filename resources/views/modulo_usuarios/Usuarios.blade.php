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

                        <h1 class="card-title">LISTA DE USUARIOS</h1>
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
                                    <th>USUARIO</th>
                                    <th>NOMBRE_USUARIO</th>
                                    <th>CONTRASEÑA</th>
                                    <th>ROL</th>
                                    <th>FECHA_ULTIMA_CONEXION</th>
                                    <th>FECHA_VENCIMIENTO</th>
                                    <th>EMAIL</th>
                                    <th>PRIMER_INGRESO</th>
                                    <th>ESTADO</th>
                                    <th>FECHA_CREACION</th>
                                    <th>CREADO_POR</th>
                                    <th>FECHA_MODIFICACION</th>
                                    <th>MODIFICADO_POR</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <!-- Tabla_BODY -->
                            <tbody>
                                @foreach ($Usuarios as $Usuario)
                                    <tr>
                                        <th>{{ $con = $con + 1 }}</th>
                                        <td>{{ $Usuario['id_usuario'] }}</td>
                                        <td>{{ $Usuario['usuario'] }}</td>
                                        <td>{{ $Usuario['nombre_usuario'] }}</td>
                                        <td>{{ $Usuario['contrasena'] }}</td>
                                        <td>{{ $Usuario['rol'] }}</td>
                                        <td>{{ $Usuario['fecha_ultima_conexion'] }}</td>
                                        <td>{{ $Usuario['fecha_vencimiento'] }}</td>
                                        <td>{{ $Usuario['email'] }}</td>
                                        <td>{{ $Usuario['primer_ingreso'] }}</td>
                                        <td>{{ $Usuario['estado'] }}</td>
                                        <td>{{ $Usuario['fecha_creacion'] }}</td>
                                        <td>{{ $Usuario['creado_por'] }}</td>
                                        <td>{{ $Usuario['fecha_modificacion'] }}</td>
                                        <td>{{ $Usuario['modificado_por'] }}</td>

                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @if ($permiso_actualizacion == 1)
                                                    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{ $Usuario['id_usuario'] }}">
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

<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">


            <div class="modal-header">
              <h4 class="modal-title">AGREGAR UN NUEVO USUARIO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="agregar_usuario" method="post">
            @csrf
            <div class="modal-body">
            <div class="row">

                <div class="col-md-6">
                <div class="form-group">
                    <label for="">USUARIO</label>
                    <input type="text" id="usu" name="usu" class="form-control" required>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="">NOMBRE_USUARIO</label>
                    <input type="text" id="nom_usu" name="nom_usu" class="form-control" required>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="">CONTRASEÑA</label>
                    <input type="password" id="contra" name="contra" class="form-control" required>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                <label for="">ROL</label>
                <select id="rol" name="rol" class="form-control"requied>
                <option >SELECCIONA</option>
                 @foreach ($tblrol as $tbl)
                <option value="{{ $tbl['id_rol']}}">{{$tbl["rol"]}}</option>
                @endforeach
                </select>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="">EMAIL</label>
                    <input type="text" id="correo" name="correo" class="form-control"  required>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="">PRIMER_INGRESO</label>
                    <input type="text" id="ingreso" name="ingreso" class="form-control"  required>
                </div>
                </div>

               

                <div class="col-md-6">
                <div class="form-group">
                <label for="">ESTADO</label>
                <select id="estdo" name="estdo" class="form-control"requied>
                <option >SELECCIONA</option>
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
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

@endsection
