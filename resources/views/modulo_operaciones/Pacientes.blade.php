@extends ('layouts.principal')
@section('content')


<br>
<div value="{{$con=0}}"></div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!--Tarjeta-->
                <div class="card">
                    <!--Tarjeta_CABEZA-->
                    <div class="card-header">
                        <h1 class="card-title">LISTA DE PACIENTES</h1>
                        <div class="card-tools">
                            @if($permiso_insercion == 1)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+ NUEVO</button>
                            @endif
                            <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
                        </div>
                    </div>

                    <div class="card-body"> <!--Tarjeta_BODY-->
                        <!--Tabla-->
                        <table id="example1" class="table table-bordered table-striped">
                            <!--Tabla_CABEZA-->
                            <thead class="text-center bg-danger blue text-white">
                                <tr>
                                    <th>n°</th>
                                    <th>CODIGO</th>
                                    <th>DNI</th>
                                    <th>NOMBRES</th>
                                    <th>APELLIDOS</th>
                                    <th>FECHA_NACIMIENTO</th>
                                    <th>EMAIL</th>
                                    <th>DIRECCION</th>
                                    <th>CELULAR</th>
                                    <th>TRATAMIENTO_MEDICO</th>
                                    <th>NOMBRE_USUARIO</th>
                                    <th>ESTADO</th>
                                    <th>FECHA_CREACION</th>
                                    <th>CREADO_POR</th>
                                    <th>FECHA_MODIFICACION</th>
                                    <th>MODIFICADO_POR</th>
                                    <th>GENERO</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <!--Tabla_BODY-->
                            <tbody>
                                @foreach ($Pacientes as $Paciente)
                                <tr>
                                    <th>{{$con=$con+1}}</th>
                                    <td>{{ $Paciente["id_paciente"]}}</td>
                                    <td>{{ $Paciente["dni_paciente"]}}</td>
                                    <td>{{ $Paciente["nombre_paciente"]}}</td>
                                    <td>{{ $Paciente["apellido_paciente"]}}</td>
                                    <td>{{ $Paciente["fecha_nacimiento"]}}</td>
                                    <td>{{ $Paciente["email"]}}</td>
                                    <td>{{ $Paciente["direccion"]}}</td>
                                    <td>{{ $Paciente["celular"]}}</td>
                                    <td>{{ $Paciente["tratamiento_medico"]}}</td>
                                    <td>{{ $Paciente["nombre_usuario"]}}</td>
                                    <td>{{ $Paciente["estado"]}}</td>
                                    <td>{{ $Paciente["fecha_creacion"]}}</td>
                                    <td>{{ $Paciente["creado_por"]}}</td>
                                    <td>{{ $Paciente["fecha_modificacion"]}}</td>
                                    <td>{{ $Paciente["modificado_por"]}}</td>
                                    <td>{{ $Paciente["genero"]}}</td>
                                    <th>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if($permiso_edicion == 1)
                                                <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Paciente['id_paciente']}}"><i class="bi bi-pencil-fill"></i> ACTUALIZAR </a>
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--FIN_Tabla-->
                    </div>
                </div>
                <!--FIN_Tarjeta-->
            </div>
        </div>
    </div>
</section>
<!--MODAL EDITAR-->
@foreach ($Pacientes as $Paciente)
<div class="modal fade" id="modal-editor-{{$Paciente['id_paciente']}}">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">ACTUALIZAR PACIENTE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="editar_paciente" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Paciente['id_paciente']}}" required>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">DNI</label>
                                <input type="text" id="dni" name="dni" class="form-control" value="{{$Paciente['dni_paciente']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">NOMBRE</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{$Paciente['nombre_paciente']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">APELLIDOS</label>
                                <input type="text" id="apellido" name="apellido" class="form-control" value="{{$Paciente['apellido_paciente']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">FECHA_NACIMIENTO</label>
                                <input type="date" id="nacimiento" name="nacimiento" class="form-control" value="{{$Paciente['fecha_nacimiento']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">EMAIL</label>
                                <input type="text" id="email" name="email" class="form-control" value="{{$Paciente['email']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">DIRECCION</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" value="{{$Paciente['direccion']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">CELULAR</label>
                                <input type="text" id="celular" name="celular" class="form-control" value="{{$Paciente['celular']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">TRATAMIENTO MEDICO</label>
                                <input type="text" id="tratamiento" name="tratamiento" class="form-control" value="{{$Paciente['tratamiento_medico']}}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">USUARIO</label>
                                <select id="usuario" name="usuario" class="form-control" requied>
                                    @foreach ($tblusuario as $tbl)
                                    <option value="{{ $tbl['id_usuario']}}">{{$tbl["nombre_usuario"]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">ESTADO</label>
                                <select id="estdo" name="estdo" class="form-control" requied>
                                    @foreach ($tblestado as $tbl)
                                    <option value="{{ $tbl['id_estado']}}">{{$tbl["estado"]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">GENERO</label>
                                <input type="text" id="genero" name="genero" class="form-control" value="{{$Paciente['genero']}}" required>
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endforeach

<!--AGREGAR TIPO ENTIDAD-->



<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h4 class="modal-title">AGREGAR UN NUEVO PACIENTE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_paciente" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">DNI</label>
                                <input type="text" id="dni" name="dni" class="form-control" required>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">NOMBRE</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">APELLIDOS</label>
                                <input type="text" id="apellido" name="apellido" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">FECHA_NACIMIENTO</label>
                                <input type="date" id="nacimiento" name="nacimiento" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">EMAIL</label>
                                <input type="text" id="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">DIRECCION</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">CELULAR</label>
                                <input type="text" id="celular" name="celular" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">TRATAMIENTO MEDICO</label>
                                <input type="text" id="tratamiento" name="tratamiento" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">USUARIO</label>
                                <select id="usuario" name="usuario" class="form-control" requied>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblusuario as $tbl)
                                    <option value="{{ $tbl['id_usuario']}}">{{$tbl["nombre_usuario"]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">ESTADO</label>
                                <select id="estdo" name="estdo" class="form-control" requied>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblestado as $tbl)
                                    <option value="{{ $tbl['id_estado']}}">{{$tbl["estado"]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">GENERO</label>
                                <input type="text" id="genero" name="genero" class="form-control" required>
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
<!-- /.modal -->
@endsection()