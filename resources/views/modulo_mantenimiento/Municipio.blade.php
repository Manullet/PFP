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
            <h1 class="card-title">LISTA DE MUNICIPIOS</h1>
            <div class="card-tools">
              <!-- Mostrar botón solo si el usuario tiene permiso para crear -->
              @if($permiso_insercion == 1)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+NUEVO</button>
              @endif
              <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
            </div>
          </div>

          <div class="card-body"> <!--Tarjeta_BODY-->
            <!--Tabla-->
            <table id="example1" class="table table-bordered table-striped  ">
              <!--Tabla_CABEZA-->
              <thead class="text-center bg-danger blue text-white ">
                <tr>
                  <th>n°</th>
                  <th>CODIGO</th>
                  <th>DEPARTAMENTO</th>
                  <th>MUNICIPIO</th>
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
                @foreach ($Municipios as $Municipio)
                <tr>
                  <th>{{$con=$con+1}}</th>
                  <td>{{ $Municipio["id_municipio"]}}</td>
                  <td>{{ $Municipio["nombre_departamento"]}}</td>
                  <td>{{ $Municipio["nombre_municipio"]}}</td>
                  <td>{{ $Municipio["estado"]}}</td>
                  <td>{{ $Municipio["fecha_creacion"]}}</td>
                  <td>{{ $Municipio["creado_por"]}}</td>
                  <td>{{ $Municipio["fecha_modificacion"]}}</td>
                  <td>{{ $Municipio["modificado_por"]}}</td>
                  <th>
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <!-- Mostrar botón solo si el usuario tiene permiso para editar -->
                      @if($permiso_edicion == 1)
                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Municipio['id_municipio']}}"><i class="bi bi-pencil-fill"></i> ACTUALIZAR </a>
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
@foreach ($Municipios as $Municipio)
<div class="modal fade" id="modal-editor-{{$Municipio['id_municipio']}}">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">ACTUALIZAR MUNICIPIO</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="editar_municipio" method="post">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Municipio['id_municipio']}}" required>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">DEPARTAMENTO</label>
                <select id="depto" name="depto" class="form-control" required>
                  @foreach ($tbldepto as $tbl)
                  <option value="{{ $tbl['id_departamento']}}">{{$tbl["nombre_departamento"]}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">MUNICIPIO</label>
                <input type="text" id="municipio" name="municipio" class="form-control" value="{{$Municipio['nombre_municipio']}}" required>
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

<!--AGREGAR MUNICIPIO-->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">AGREGAR UN NUEVO MUNICIPIO</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="agregar_municipio" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label for="">DEPARTAMENTO</label>
                <select id="depto" name="depto" class="form-control" required>
                  <option>SELECCIONA</option>
                  @foreach ($tbldepto as $tbl)
                  <option value="{{ $tbl['id_departamento']}}">{{$tbl["nombre_departamento"]}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">MUNICIPIO</label>
                <input type="text" id="municipio" name="municipio" class="form-control" required>
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
