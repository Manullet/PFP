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
                    <!-- Cabecera de la tarjeta -->
                    <div class="card-header">
                        <h1 class="card-title">LISTA DE FACTURAS DE PRODUCTOS CANJEABLES</h1>
                        <div class="card-tools">
                            @if($permiso_insercion == 1)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">+ NUEVO</button>
                            @endif
                            <a href="{{ url('inicio') }}" class="btn btn-secondary">VOLVER</a>
                        </div>
                    </div>
                    <!-- Cuerpo de la tarjeta -->
                    <div class="card-body">
                        <!-- Tabla -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="text-center bg-danger text-white">
                                <tr>
                                    <th>n°</th>
                                    <th>CODIGO</th>
                                    <th>FACTURA</th>
                                    <th>DNI_PACIENTE</th>
                                    <th>NOMBRE_PACIENTE</th>
                                    <th>APELLIDO_PACIENTE</th>
                                    <th>NOMBRE_PRODUCTO</th>
                                    <th>CANTIDAD_PRODUCTO</th>
                                    <th>FECHA_CREACION</th>
                                    <th>CREADO_POR</th>
                                    <th>FECHA_MODIFICACION</th>
                                    <th>MODIFICADO_POR</th>
                                    @if($permiso_edicion == 1)
                                    <th>ACCION</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Facturas as $Factura)
                                <tr>
                                    <th>{{ $con = $con + 1 }}</th>
                                    <td>{{ $Factura['id_factura'] }}</td>
                                    <td>{{ $Factura['factura'] }}</td>
                                    <td>{{ $Factura['dni_paciente'] }}</td>
                                    <td>{{ $Factura['nombre_paciente'] }}</td>
                                    <td>{{ $Factura['apellido_paciente'] }}</td>
                                    <td>{{ $Factura['nombre_producto'] }}</td>
                                    <td>{{ $Factura['cantidad_producto'] }}</td>
                                    <td>{{ $Factura['fecha_creacion'] }}</td>
                                    <td>{{ $Factura['creado_por'] }}</td>
                                    <td>{{ $Factura['fecha_modificacion'] }}</td>
                                    <td>{{ $Factura['modificado_por'] }}</td>
                                    @if($permiso_edicion == 1)
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-editor-{{$Factura['id_factura']}}">
                                                <i class="bi bi-pencil-fill"></i> ACTUALIZAR
                                            </a>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Fin tarjeta -->
            </div>
        </div>
    </div>
</section>

<!-- Modal de notificación de canje -->
@if(session('status_message'))
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Notificación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ session('status_message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    $(document).ready(function() {
        if ($('#statusModal').length) {
            $('#statusModal').modal('show');
        }
    });
</script>

<!-- Modal para agregar una factura -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">AGREGAR UNA FACTURA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="agregar_factura" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">FACTURA</label>
                                <input type="text" id="factura" name="factura" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">PACIENTE</label>
                                <select id="paciente" name="paciente" class="form-control select2" required>
                                    <option>SELECCIONA</option>
                                    @foreach ($tblpaciente as $tbl)
                                    <option value="{{ $tbl['id_paciente'] }}">{{ $tbl['dni_paciente'] }}</option>
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
                                    <option value="{{ $tbl['id_producto'] }}">{{ $tbl['nombre_producto'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">CANTIDAD_PRODUCTO</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" required>
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