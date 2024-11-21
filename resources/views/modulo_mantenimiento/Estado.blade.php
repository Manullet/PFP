@extends ('layouts.principal')

@section('content')

<br>

<!-- BOTON AGREGA -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">LISTA DE ESTADOS</h1>
                        <div class="card-tools">
                            <!-- Mostrar botón solo si el usuario tiene permiso para agregar -->
                            @if($permiso_insercion == 1)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#model_agregar">AGREGAR</button>
                            @endif
                            <a href="{{ url('inicio') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>

                    <!-- TABLA CONTENIDO -->
                    <!-- cuerpo -->
                    <div class="card-body">
                        <!-- tabla -->
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead class=" text-center bg-danger blue text-white">
                                <tr>
                                    <th>CODIGO</th>
                                    <th>ESTADO</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Estados as $Estado)
                                <tr>
                                    <td>{{ $Estado["id_estado"]}}</td>
                                    <td>{{ $Estado["estado"]}}</td>

                                    <td class="project-actions text-right">
                                        <!-- Mostrar botón solo si el usuario tiene permiso para editar -->
                                        @if($permiso_edicion == 1)
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#model_editar-{{ $Estado['id_estado']}}">
                                                <i class="bi bi-pencil"></i> Actualizar 
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL DE EDITAR -->
@foreach ($Estados as $Estado)
<div class="modal fade" id="model_editar-{{ $Estado['id_estado']}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- cabeza-->
            <div class="modal-header">
            </div>
            <!-- cuerpo-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Actualizar Estado</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <!-- formulario -->
                                <form action="EditarEstado" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <input type="hidden" id="cod" name="cod" class="form-control" value="{{ $Estado['id_estado']}}" required>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">ESTADO</label>
                                                <input type="text" id="estado" name="estado" class="form-control" value="{{ $Estado['estado']}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal agregar Estado -->
<div class="modal fade" id="model_agregar" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- cabeza-->
            <div class="modal-header">
                <h4 class="modal-title">Agregar un nuevo Estado</h4>
            </div>
            <!-- cuerpo-->
            <div class="modal-body">
                <!-- contenido cuerpo-->
                <form action='Agregar_Estado' method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">ESTADO</label>
                                <input type="text" id="estado" name="estado" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">AGREGAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Modal termina agregar Estado-->

@endsection()



