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
            <h1 class="card-title">LISTA DE VIA_ADMINISTRACION DE MEDICAMENTOS</h1>
            <div class="card-tools">
                <!-- Mostrar botón solo si el usuario tiene permiso para crear -->
                @if($permiso_insercion == 1)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+ NUEVO</button>
                @endif
                <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
            </div>
        </div>
       
        <div class="card-body">  <!--Tarjeta_BODY-->
            <!--Tabla-->
            <table id="example1" class="table table-bordered table-striped">
                <!--Tabla_CABEZA-->
                <thead class="text-center bg-danger text-white">
                    <tr>
                        <th>n°</th>
                        <th>CODIGO</th>
                        <th>VIA_ADMINISTRACION</th>
                        <th>ESTADO</th>
                        <th>FECHA_CREACION</th>
                        <th>CREADO_POR</th>
                        <th>FECHA_MODIFICACION</th>
                        <th>MODIFICADO_POR</th>
                        <th>ACCION</th>
                    </tr>
                </thead>
                <!--Tabla_BODY-->
                <tbody>
                    @foreach ($ViaAdmin as $Administracion)
                    <tr>
                        <th>{{$con = $con + 1}}</th>
                        <td>{{ $Administracion["id_via_administracion"]}}</td>
                        <td>{{ $Administracion["via_administracion"]}}</td>
                        <td>{{ $Administracion["estado"]}}</td>
                        <td>{{ $Administracion["fecha_creacion"]}}</td>
                        <td>{{ $Administracion["creado_por"]}}</td>
                        <td>{{ $Administracion["fecha_modificacion"]}}</td>
                        <td>{{ $Administracion["modificado_por"]}}</td>
                        <th>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <!-- Mostrar botón solo si el usuario tiene permiso para editar -->
                                @if($permiso_edicion == 1)
                                    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Administracion['id_via_administracion']}}">
                                        <i class="bi bi-pencil-fill"></i> ACTUALIZAR
                                    </a>
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
@foreach ($ViaAdmin as $Administracion)
<div class="modal fade" id="modal-editor-{{$Administracion['id_via_administracion']}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ACTUALIZAR VIA_ADMINISTRACION</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="editar_viadmin" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Administracion['id_via_administracion'] }}" required>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">VIA_ADMINISTRACION</label>
                            <input type="text" id="via" name="via" class="form-control" value="{{ $Administracion['via_administracion'] }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ESTADO</label>
                            <select id="estdo" name="estdo" class="form-control" required>
  @foreach ($tblestado as $tbl)
    <option value="{{ $tbl['id_estado'] }}" 
            {{ $tbl['id_estado'] == optional($Administracion)['id_estado'] ? 'selected' : '' }}>
      {{ $tbl["estado"] }}
    </option>
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

<!--MODAL AGREGAR-->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">AGREGAR NUEVO VIA_ADMINISTRACION</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_viadmin" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">VIA_ADMINISTRACION</label>
                            <input type="text" id="via" name="via" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ESTADO</label>
                            <select id="estdo" name="estdo" class="form-control" required>
  @foreach ($tblestado as $tbl)
    <option value="{{ $tbl['id_estado'] }}" 
            {{ $tbl['id_estado'] == optional($Administracion)['id_estado'] ? 'selected' : '' }}>
      {{ $tbl["estado"] }}
    </option>
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
