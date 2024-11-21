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
            <h1 class="card-title">LISTA DE ESTADOS DE CANJES</h1>
            <div class="card-tools">
              <!-- Mostrar botón de nuevo estado solo si el usuario tiene permiso para insertar -->
              @if($permiso_insercion == 1)
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+ NUEVO</button>
              @endif
              <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
            </div>
          </div>

          <div class="card-body"> <!--Tarjeta_BODY-->
            <!--Tabla-->
            <table id="example1" class="table table-bordered table-striped  ">
              <!--Tabla_CABEZA-->
              <thead class=" text-center bg-danger blue text-white ">
                <tr>
                  <th>n°</th>
                  <th>CODIGO</th>
                  <th>ESTADO CANJE</th>
                  <th>ACCION</th>
                </tr>
              </thead>
              <!--Tabla_BODY-->
              <tbody>
                @foreach ($Estacanje as $Canje)
                <tr>
                  <th>{{$con=$con+1}}</th>
                  <td>{{ $Canje["id_estado_canje"]}}</td>
                  <td>{{ $Canje["estado_canje"]}}</td>
                  <th>
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <!-- Mostrar botón de editar solo si el usuario tiene permiso para editar -->
                      @if($permiso_edicion == 1)
                      <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Canje['id_estado_canje']}}"><i class="bi bi-pencil-fill"></i> ACTUALIZAR </a>
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
@foreach ($Estacanje as $Canje)
<div class="modal fade" id="modal-editor-{{$Canje['id_estado_canje']}}">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">ACTUALIZAR ESTADO CANJE</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="editar_estado_canje" method="post">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Canje['id_estado_canje']}}" required>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">ESTADO_CANJE</label>
                <input type="text" id="canje" name="canje" class="form-control" value="{{$Canje['estado_canje']}}" required>
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

<!--AGREGAR ESTADO CANJE-->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">AGREGAR UN NUEVO ESTADO CANJE</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="agregar_estado_canje" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label for="">ESTADO_CANJE</label>
                <input type="text" id="canje" name="canje" class="form-control" value="" required>
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