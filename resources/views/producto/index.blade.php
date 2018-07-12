@extends('layouts.app')

@section('content')


<div class="container">
	<div class="row mb-2">
		<div class="col-md-3">
			<a href="{{ route('producto.create') }}" class="btn btn-danger"  title="Crear un nuevo producto">Nuevo</a>
		</div>
		<div class="col-md-5">
			{!! Form::open(['route' => 'searchProduct', 'method' => 'GET', 'class' => 'form-inline']) !!}
			<div class="input-group">
			    <div class="input-group-prepend">
			      <button type="submit" name="Buscar" class="btn btn-lifgh" data-toggle="tooltip" data-placement="top" title="Presiona para buscar">Buscar</button>
			    </div>
			    {{ Form::text('search',$search,['class' => 'form-control', 'placeholder' => 'Codigo Producto']) }}
			 </div>
			{{ Form::close() }}
		</div>
	</div>
    <div class="row justify-content-center">
        <div class="col-md-12">
        	@include('producto.fragment.error')
			@include('producto.fragment.success')
			<table class="table">
				<thead class="thead-dark">
				<tr>
				  <th scope="col">Imagen</th>
				  <th scope="col">Codigo</th>				  
				  <th scope="col">Nombre</th>
				  <th scope="col">Marca</th>
				  <th scope="col">Modelo</th>
				  <th scope="col">Precio</th>
				  <th scope="col">Stock</th>
				  <th scope="col" colspan="2"></th>
				</tr>
				</thead>
				<tbody id="tbody">

				@foreach ($productos as $producto)
					<tr>						
						<td>
							@if($producto->imagenes->get(0))
								@foreach ($producto->imagenes as $imagen)
									@if($imagen->es_principal == 1)
										<img src="{{ asset('storage/'.$imagen->ruta ) }}" height="40px" width="40px" class="img-thumbnail">		
									@endif								
								@endforeach
								
							@else
    							<img src="{{ asset('img/no-imagen.png') }}" height="40px" width="40px" class="img-thumbnail">
							@endif
						</td>
						<td>{{ $producto->id }}</td>
						<td>{{ $producto->nombre }}</td>
						<td>{{ $producto->marca }}</td>
						<td>{{ $producto->modelo }}</td>
						<td>{{ $producto->precio_normal }}</td>
						<td>{{ $producto->stock }}</td>
						<td width="110px">
							<a href="{{ route('producto.edit', [$producto->id]) }}" class="btn btn-warning bt-sm" title="Editar producto"><i class="far fa-edit"></i></a>
						
							<button type="button" class="btn btn-danger bt-sm" onclick="modalEliminarProducto({{ $producto->id }})"  title="Eliminar producto"><i class="far fa-trash-alt"></i></button>
						</td>
						<td width="55px">
							<form action="{{ route('oferta.index') }}" method="GET">
				                @csrf
				                <input type="hidden" name="idProducto" value="{{ $producto->id }}">
				                <button type="submit" class="btn btn-success bt-sm" title="Ofertas producto"><i class="fas fa-tags"></i></button>
				            </form>
						</td>
					</tr>
				@endforeach

				</tbody>
			</table>

			<!-- Paginacion -->
			{{ $productos->links() }}
        </div>
    </div>
</div>




@include('producto.modal.modalConfirmacionProducto')


<script type="text/javascript">
	
function modalEliminarProducto(id) {
    $('#idProductoModalConfirmacion').val(id);
    $('#modalConfirmacionProducto').modal('show');
}

function confirmarEliminacionProducto(){
    $.ajax({
        url: '{{ route('productoRemoveModal') }}',
        data: {
            'id': $('#idProductoModalConfirmacion').val(),
        },
        type: 'GET',
        success: function(data) {
            $('#modalConfirmacionProducto').modal('hide');
            location.reload();
        }
    });
}

</script>

@endsection