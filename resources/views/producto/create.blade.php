@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('createProducto') }}
@endsection

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
                    <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data"> 
                        @csrf

                        <div class="form-group row">
                            <label for="id" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="id" name="id" placeholder="ID o codigo" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" rows="7" maxlength="1500">
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="precio_normal" class="col-sm-3 col-form-label">Precio normal</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="precio_normal" name="precio_normal" placeholder="Precio normal" value="" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" value="" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marca" class="col-sm-3 col-form-label">Marca</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modelo" class="col-sm-3 col-form-label">Modelo</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_categoria" class="col-sm-3 col-form-label">Categoria</label>
                            <div class="col-sm-9">
                                <select class="js-example-basic-single form-control " id="id_categoria" name="id_categoria" onchange="loadingSubCategoria(this.value)">
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="div-subcat" style="display: none;">
                            <label for="id_subcategoria" class="col-sm-3 col-form-label">Sub Categoria</label>
                            <div class="col-sm-9">
                                <select class="js-example-basic-single form-control " id="id_subcategoria" name="id_subcategoria">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagenes" class="col-sm-3 col-form-label">Imagenes</label>
                            <div class="custom-file col-sm-9">
                                <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form> 
                    <!-- END FORMULARIO MIS DATOS-->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function loadingSubCategoria($id_categoria){
    $('#id_subcategoria').html('');
    $.ajax({
        url: '/subcategorias/'+$id_categoria,
        type: 'GET',
        dataType: 'json',
        //data: {id_categoria: $id_categoria},
    })
    .done(function(data) {
        for (var i = 0; i < data.length; i++) {
            $('#id_subcategoria').append('<option value=' + data[i].id + '>' + data[i].nombre + '</option>');
        }
        //$('#id_subcategoria').hide();
        $('#div-subcat').show();            
    })
    .fail(function(data) {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
</script>

@endsection