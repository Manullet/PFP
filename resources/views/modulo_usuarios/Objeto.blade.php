
@extends ('layouts.principal')
@section('content')
<br>
                <!-- TABLA CONTENIDO CENTRAL -->
                <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">LISTA DE OBJETOS</h1>
                    <div class="card-tools">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i> NUEVO
                    </button>

                    </div>
                    </div>
        
              <!-- /.INICIO DE LA TABLA -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-sm">
              <thead class=" text-center bg-danger blue text-white">

                  <tr>
                    <th>CODIGO</th>
                    <th>OBJETO</th>
                    <th>TIPO OBJETO</th>
                    <th>DESCRIPCION</th>
                    <th>CREADO POR</th>
                    <th>FECHA CREACION</th>
                    <th>MODIFICADO POR</th>
                    <th>FECHA MODIFICACION</th>
                  </tr>
                  </thead>
                  <tbody>
                 
                    <!-- CONTENIDO QUE VA TENER LA TABLA  -->
                
                  <tr>
                    <td>1</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>....</td>
                    <td>....</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>....</td>
                    <td>....</td>

                  </tr>
                
                  </tfoot>
                </table>
              </div>
              <!-- /.CIERRE -->
            </div>
            <!-- /carta -->

        </div>
        </div>
        </div>
    </section>
<!-- TABLA CONTENIDO CENTRAL -->

<!-- MODAL DE ELIMINAR-->


<div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">ELIMINAR OBJETO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>¿ESTA SEGURO QUE DESEAS ELIMINAR?&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">CANCELAR</button>
              <button type="button" class="btn btn-outline-light">CONFIRMAR</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


<!-- MODAL DE AGREGAR -->
<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">AGREGAR OBJETO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">OBJETO</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="OBETO">
                  </div>



                  <div class="form-group">
                    <label for="exampleInputPassword1">TIPO OBJETO</label>
                    <input type="descripcion" class="form-control" id="exampleInputPassword1" placeholder="TIPO OBJETO">
                  </div>
                 
                  <div class="form-group">
                    <label for="exampleInputPassword1">DRSCRIPCION</label>
                    <input type="descripcion" class="form-control" id="exampleInputPassword1" placeholder="DESCRIPCION">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">CREADO POR</label>
                    <input type="correo" class="form-control" id="exampleInputPassword1" placeholder="CREADO POR">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">FECHA CREACION</label>
                    <input type="date" class="form-control" id="exampleInputPassword1" placeholder="CREADO POR">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">MODIFICADO POR</label>
                    <input type="correo" class="form-control" id="exampleInputPassword1" placeholder="MODIFICADO POR">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">FECHA MODIFICACION</label>
                    <input type="date" class="form-control" id="exampleInputPassword1" placeholder="FECHA MODIFICACION">
                  </div>
                

                <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary" data-dismiss="modal">CERRAR</button>
              <button type="button" class="btn btn-primary">AGREGAR</button>
            </div>
              </form>
            </div>
            </div>
                <!-- /.card-body -->
            <!-- /.card -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


@endsection()
