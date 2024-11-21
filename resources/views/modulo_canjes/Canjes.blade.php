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
            <h1 class="card-title">LISTA DE CANJES</h1>
            <div class="card-tools">
              <!-- Mostrar el botón solo si el permiso de inserción es 1 -->
              @if ($permiso_insercion == 1)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+ NUEVO</button>
              @endif
              <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
            </div>
          </div>

          <div class="card-body">  <!-- Tarjeta Body -->
            <!-- Tabla -->
            <table id="example1" class="table table-bordered table-striped">
              <!-- Tabla Cabeza -->
              <thead class="text-center bg-danger blue text-white">
                <tr>
                  <th>n°</th>
                  <th>CODIGO</th>
                  <th>FECHA_REGISTRO</th>
                  <th>TIPO_REGISTRO</th>
                  <th>RTN_REGISTRO</th>
                  <th>NOMBRE_FARMACIA</th>
                  <th>DNI_PACIENTE</th>
                  <th>NOMBRE_PACIENTE</th>
                  <th>APELLIDO_PACIENTE</th>
                  <th>NOMBRE_PRODUCTO</th>
                  <th>CANTIDAD</th>
                  <th>ESTADO_CANJE</th>
                  <th>COMENTARIOS</th>
                  <th>FECHA_CREACION</th>
                  <th>CREADO_POR</th>
                  <th>FECHA_MODIFICACION</th>
                  <th>MODIFICADO_POR</th>
                </tr>
              </thead>
              <!-- Tabla Body -->
              <tbody>
                @foreach ($Canjes as $Canje)
                <tr>
                  <th>{{$con = $con + 1}}</th>
                  <td>{{ $Canje["id_registro"]}}</td>
                  <td>{{ $Canje["fecha_registro"]}}</td>
                  <td>{{ $Canje["tipo_registro"]}}</td>
                  <td>{{ $Canje["rtn_farmacia"]}}</td>
                  <td>{{ $Canje["nombre_farmacia"]}}</td>
                  <td>{{ $Canje["dni_paciente"]}}</td>
                  <td>{{ $Canje["nombre_paciente"]}}</td>
                  <td>{{ $Canje["apellido_paciente"]}}</td>
                  <td>{{ $Canje["nombre_producto"]}}</td>
                  <td>{{ $Canje["cantidad"]}}</td>
                  <td>{{ $Canje["estado_canje"]}}</td>
                  <td>{{ $Canje["comentarios"]}}</td>
                  <td>{{ $Canje["fecha_creacion"]}}</td>
                  <td>{{ $Canje["creado_por"]}}</td>
                  <td>{{ $Canje["fecha_modificacion"]}}</td>
                  <td>{{ $Canje["modificado_por"]}}</td>
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

<!-- Modal para agregar nuevo registro -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">AGREGAR UN NUEVO REGISTRO CANJE</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Formulario para agregar -->
      <form action="agregar_registrocanje" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">TIPO_REGISTRO</label>
                <select id="registro" name="registro" class="form-control select2" required>
                  <option>SELECCIONA</option>
                  @foreach ($tblregistro as $tbl)
                  <option value="{{ $tbl['id_tipo_registro']}}">{{$tbl["tipo_registro"]}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">FARMACIA</label>
                <select id="farmacia" name="farmacia" class="form-control select2" required>
                  <option>SELECCIONA</option>
                  @foreach ($tblfarmacia as $tbl)
                  <option value="{{ $tbl['id_farmacia']}}">{{$tbl["rtn_farmacia"]}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">PACIENTE</label>
                <select id="paciente" name="paciente" class="form-control select2" required>
                  <option>SELECCIONA</option>
                  @foreach ($tblpaciente as $tbl)
                  <option value="{{ $tbl['id_paciente']}}">{{$tbl["dni_paciente"]}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">PRODUCTO</label>
                <select id="producto" name="producto" class="form-control select2" required>
                  <option>SELECCIONA</option>
                  @foreach ($tblproducto as $tbl)
                  <option value="{{ $tbl['id_producto']}}">{{$tbl["nombre_producto"]}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">CANTIDAD</label>
                <input type="text" id="cantidad" name="cantidad" class="form-control" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">ESTADO_CANJE</label>
                <select id="estadocanje" name="estadocanje" class="form-control" required>
                  <option>SELECCIONA</option>
                  @foreach ($tblestadocanje as $tbl)
                  <option value="{{ $tbl['id_estado_canje']}}">{{$tbl["estado_canje"]}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">COMENTARIOS</label>
                <input type="text" id="comentarios" name="comentarios" class="form-control" required>
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
