@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Datos Producto</div>

                <div class="card-body">                	
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
	
					<!-- FORMULARIO MIS DATOS-->
					@include('producto.fragment.error')
					@include('producto.fragment.success')

                    
                    {!! Form::model($producto, [
                        'method'  => 'PUT',
                        'route'   => ['producto.update', $producto->id],
                        'enctype' => 'multipart/form-data'
                        ]) !!}

                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="id" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="id" name="id" placeholder="ID o codigo" readonly value="{{ $producto->id }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{{ $producto->nombre }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" value="{{ $producto->descripcion }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="precio_normal" class="col-sm-3 col-form-label">Precio normal</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="precio_normal" name="precio_normal" placeholder="Precio normal" value="{{ $producto->precio_normal }}" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" value="{{ $producto->stock }}" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marca" class="col-sm-3 col-form-label">Marca</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca" value="{{ $producto->marca }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modelo" class="col-sm-3 col-form-label">Modelo</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo" value="{{ $producto->modelo }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_categoria" class="col-sm-3 col-form-label">Categoria</label>
                            <div class="col-sm-9">
                                <select class="js-example-basic-single form-control " id="id_categoria" name="id_categoria" onchange="loadingSubCategoria(this.value)">
                                    @foreach ($categorias as $categoria)
                                        @if($categoria->id == $id_categoria)
                                            <option value="{{ $categoria->id }}" selected>{{ $categoria->nombre }}</option>
                                        @else
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endif
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="div-subcat">
                            <label for="id_subcategoria" class="col-sm-3 col-form-label">Sub Categoria</label>
                            <div class="col-sm-9">
                                <select class="js-example-basic-single form-control " id="id_subcategoria" name="id_subcategoria">
                                    @foreach ($subCategorias as $subCategoria)
                                        @if($subCategoria->id == $producto->id_subcategoria)
                                            <option value="{{ $subCategoria->id }}" selected>{{ $subCategoria->nombre }}</option>
                                        @else
                                            <option value="{{ $subCategoria->id }}">{{ $subCategoria->nombre }}</option>
                                        @endif
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagenes" class="col-sm-3 col-form-label">Subir imagenes</label>
                            <div class="custom-file col-sm-9">
                                <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </div>
                     {{ Form::close() }}
                    <!-- END FORMULARIO MIS DATOS-->
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">Imagenes publicadas</div>

                <div class="card-body">  
                    <div class="form-group row">
                        @if($producto->imagenes->get(0))
                            
                            @foreach ($producto->imagenes as $element)
                            
                                <div class="card m-1" style="width: 8rem;">    
                                    <img src="{{ asset('storage/'.$element->ruta ) }}" alt="Card image cap" class="card-img-top" height="100px" width="100px">
                                    <div class="card-body">
                                        
                                        

                                        <form action="{{ route('imagen.destroy',$element->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            @if($element->es_principal)
                                                <button type="button" class="btn btn-success btn-sm" onclick="">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @else
                                                <a type="button" class="btn btn-light btn-sm" onclick="marcarPrincipal('{{ route('marcarPrincipal',$element->id) }}')">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @endif
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>


                                    </div>
                                </div>

                                                                   
                            @endforeach  
                                                             
                        @else
                            <img src="{{ asset('img/no-imagen.png') }}" height="50px" width="160px" class="img-thumbnail">
                        @endif
                    </div>
                </div>
            </div>


        </div>

        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">Caracteristicas Producto</div>

                <div class="card-body">
    
                    <form action="{{ route('especificacion.store') }}" method="POST" class="form-inline"> 
                    @csrf

                      <div class="form-group mx-sm-2 mb-2">
                        <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Nombre</div>
                        </div>
                        <input type="text" class="form-control" id="nombreEspecificacion" name="nombre" placeholder="Nombre">
                        </div>
                      </div>

                      <div class="form-group mx-sm-1 mb-2">
                        <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Descripción</div>
                        </div>
                        <input type="text" class="form-control" id="descripcionEspecificacion" name="descripcion" placeholder="Descripción">
                        </div>
                      </div>
                      <input type="hidden" name="id_producto" id="id_productoEspecificacion" value="{{ $producto->id }}">
                      <button type="submit" class="btn btn-primary mb-2 ml-2"><i class="fas fa-plus"></i></button>

                    </form>
            
                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Nombre</th>
                          <th scope="col">Descripción</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>

                        @foreach ($especificaciones as $especificacion)
                            <tr>
                              <th scope="row">{{ $especificacion->nombre }}</th>
                              <td>{{ $especificacion->descripcion }}</td>
                              <td width="110">
                                <button class="btn btn-warning" onclick="modalEditEspecificacion('{{ $especificacion->id }}','{{ $especificacion->nombre }}','{{ $especificacion->descripcion }}','{{ $especificacion->id_producto }}')"><i class="far fa-edit"></i></button>
                                <button class="btn btn-danger" onclick="modalEliminarEspecificacion('{{ $especificacion->id }}')"><i class="far fa-trash-alt"></i></button>
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

@include('producto.modal.modalEditEspecificacion')
@include('producto.modal.modalConfirmacionEspecificacion')


<script type="text/javascript">
function loadingSubCategoria(id_categoria){
    $('#id_subcategoria').html('');
    $.ajax({
        url: '/subcategorias/'+id_categoria,
        type: 'GET',
        dataType: 'json',
    })
    .done(function(data) {
        for (var i = 0; i < data.length; i++) {
            $('#id_subcategoria').append('<option value=' + data[i].id + '>' + data[i].nombre + '</option>');
        }
        $('#div-subcat').show();            
    })
    .fail(function(data) {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function marcarPrincipal(url){ 
        console.log(url);
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success:function(data){
                location.reload();
            },
            error: function( data ) {
            }
        });
}

function modalEditEspecificacion(id,nombre,descripcion,id_producto) {
    $('#idEspecificacionModal').val(id);
    $('#nombreEspecificacionModal').val(nombre);
    $('#descripcionEspecificacionModal').val(descripcion);
    $('#id_productoEspecificacionModal').val(id_producto);
    $('#modalEditEspecificacion').modal('show');
}

function guardarCambiosEspecificacion(){
    $.ajax({
        url: '{{ route('especificacionEditModal') }}',
        data: {
            'id': $('#idEspecificacionModal').val(),
            'nombre': $('#nombreEspecificacionModal').val(),
            'descripcion': $('#descripcionEspecificacionModal').val(),
            'id_producto': $('#id_productoEspecificacionModal').val()
        },
        type: 'GET',
        success: function(data) {
            $('#modalEditEspecificacion').modal('hide');
            location.reload();
        }
    });
}

function modalEliminarEspecificacion(id) {
    console.log("eliminar");
    $('#idEspecificacionModalConfirmacion').val(id);
    $('#modalConfirmacionEspecificacion').modal('show');
}

function confirmarEliminacion(){
    $.ajax({
        url: '{{ route('especificacionRemoveModal') }}',
        data: {
            'id': $('#idEspecificacionModalConfirmacion').val(),
        },
        type: 'GET',
        success: function(data) {
            $('#modalConfirmacionEspecificacion').modal('hide');
            location.reload();
        }
    });
}

</script>


<style type="text/css">
    
</style>

@endsection