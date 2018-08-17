@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('editarOferta',$oferta) }}
@endsection

@section('content')


<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Datos Oferta</div>

                <div class="card-body">                	
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
	
					<!-- FORMULARIO MIS DATOS-->
					@include('producto.fragment.error')
					@include('producto.fragment.success')
                    <form action="{{ route('oferta.update',$oferta->id) }}" method="POST"> 
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="id_producto" class="col-sm-3 col-form-label">Codigó Producto</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="id_producto" name="id_producto"value="{{ $oferta->id_producto }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_inicio" class="col-sm-3 col-form-label">Fecha Inicio</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha inicio" value="{{ $oferta->fecha_inicio }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_termino" class="col-sm-3 col-form-label">Fecha Termino</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" placeholder="Fecha termino" value="{{ $oferta->fecha_termino }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="precio_normal" class="col-sm-3 col-form-label">Precio normal</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="precio_normal" name="precio_normal" placeholder="Precio normal" readonly value="{{ $producto->precio_normal }}" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="precio_oferta" class="col-sm-3 col-form-label">Precio oferta</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="precio_oferta" name="precio_oferta" placeholder="Precio oferta" value="{{ $oferta->precio_oferta }}" min="0" onchange="calculaPorcentaje(this.value)">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="porcentaje" class="col-sm-3 col-form-label">% Oferta</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="porcentaje" name="porcentaje" placeholder="" readonly value="" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" value="{{ $oferta->stock }}" min="0" max="{{ $producto->stock }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
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

    window.onload = function() {
        calculaPorcentaje($('#precio_oferta').val());
    };
    
    function calculaPorcentaje(precio_oferta){
        var precio_normal = $('#precio_normal').val();
        var porcentaje = Math.round(100-((100/precio_normal)*precio_oferta));
        $('#porcentaje').val(porcentaje+" %");

    }
</script>

@endsection