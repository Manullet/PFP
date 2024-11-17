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
                    <h1 class="card-title">LISTA DE TIPO DE ENTIDADES</h1>
                    <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+NUEVO</button>
                    <a href="{{ url('inicio') }}" class="btn btn-secondary">Volver</a>
                   
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
                        <th>TIPO_ENTIDAD</th>
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
                      @foreach ($Tipentidad as $Entidad)
                    <tr>
                        <th>{{$con=$con+1}}</th>
                        <td>{{ $Entidad["id_tipo_entidad"]}}</td>
                        <td>{{ $Entidad["tipo_entidad"]}}</td>
                        <td>{{ $Entidad["estado"]}}</td>
                        <td>{{ $Entidad["fecha_creacion"]}}</td>
                        <td>{{ $Entidad["creado_por"]}}</td>
                        <td>{{ $Entidad["fecha_modificacion"]}}</td>
                        <td>{{ $Entidad["modificado_por"]}}</td>
                        <th>
                            <div class="btn-group" role="group" aria-label="Basic example">
                            
                            <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Entidad['id_tipo_entidad']}}"><i class="bi bi-pencil-fill"></i> ACTUALIZAR </a>
                            
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
 @foreach ($Tipentidad as $Entidad)
<div class="modal fade" id="modal-editor-{{$Entidad['id_tipo_entidad']}}">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">ACTUALIZAR TIPO DE ENTIDAD</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="editar_entidad" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
            <div class="row">
            <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Entidad['id_tipo_entidad']}}" required>
                
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">TIPO ENTIDAD</label>
                    <input type="text" id="tipo" name="tipo" class="form-control" value="{{$Entidad['tipo_entidad']}}" required>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                <label for="">ESTADO</label>
                <select id="estdo" name="estdo" class="form-control"requied>
                 @foreach ($tblestado as $tbl)
                <option value="{{$tbl['id_estado']}}">{{$tbl["estado"]}}</option>
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
              <h4 class="modal-title">AGREGAR UN TIPO DE ENTIDAD</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="agregar_entidad" method="post">
            @csrf
            <div class="modal-body">
            <div class="row">

                <div class="col-md-6">
                <div class="form-group">
                    <label for="">TIPO ENTIDAD</label>
                    <input type="text" id="tipo" name="tipo" class="form-control" required>
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
<!-- /.modal -->
@endsection()

