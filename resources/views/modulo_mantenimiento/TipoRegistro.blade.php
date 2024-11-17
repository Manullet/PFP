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
                    <h1 class="card-title">LISTA DE TIPOS DE REGISTRO</h1>
                    <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+NUEVO</button>
                    <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
                   
                    </div>
                    </div>
       
      
        <div class="card-body">  <!--Tarjeta_BODY-->
            <!--Tabla-->
            <table id="example1" class="table table-bordered table-striped  ">
                <!--Tabla_CABEZA-->
                <thead class=" text-center bg-danger blue text-white ">
                    <tr>
                        <th>n°</th>
                        <th>CODIGO</th>
                        <th>TIPO_REGISTRO</th>
                        <th>FECHA_CREACION</th>
                        <th>CREADO_POR</th>
                        <th>FECHA_MODIFICACION</th>
                        <th>MODIFICADO_POR</th>
                        <th>ACCION</th>
                       
                    </tr>
                </thead>
                <!--Tabla_BODY-->
                <tbody>
                      @foreach ($TpRegistro as $Registro)
                    <tr>
                        <th>{{$con=$con+1}}</th>
                        <td>{{ $Registro["id_tipo_registro"]}}</td>
                        <td>{{ $Registro["tipo_registro"]}}</td>
                        <td>{{ $Registro["fecha_creacion"]}}</td>
                        <td>{{ $Registro["creado_por"]}}</td>
                        <td>{{ $Registro["fecha_modificacion"]}}</td>
                        <td>{{ $Registro["modificado_por"]}}</td>
                        <th>
                            <div class="btn-group" role="group" aria-label="Basic example">
                            
                            <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Registro['id_tipo_registro']}}"><i class="bi bi-pencil-fill"></i> ACTUALIZAR </a>
                            
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
 @foreach ($TpRegistro as $Registro)
<div class="modal fade" id="modal-editor-{{$Registro['id_tipo_registro']}}">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">ACTUALIZAR EL TIPO DE REGISTRO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="editar_registro" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
            <div class="row">
            <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Registro['id_tipo_registro']}}" required>
                
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">TIPO REGISTRO</label>
                    <input type="text" id="tipo" name="tipo" class="form-control" value="{{$Registro['tipo_registro']}}" required>
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
              <h4 class="modal-title">AGREGAR UN TIPO DE REGISTRO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="agregar_registro" method="post">
            @csrf
            <div class="modal-body">
            <div class="row">

                <div class="col-md-6">
                <div class="form-group">
                    <label for="">TIPO REGISTRO</label>
                    <input type="text" id="tipo" name="tipo" class="form-control" required>
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

