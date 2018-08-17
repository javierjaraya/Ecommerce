@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('ofertas',$idProducto) }}
@endsection

@section('content')


<div class="container">
	<div class="row mb-2">
		<div class="col-md-3">
            <a class="btn btn-danger" href="{{ route('oferta.create',[$idProducto]) }}">Nuevo</a>
		</div>
		<div class="col-md-5">

		</div>
	</div>

	<div class="row justify-content-center">
        <div class="col-md-12">
        	@include('producto.fragment.error')
			@include('producto.fragment.success')
			<table class="table">
				<thead class="thead-dark">
				<tr>
				  <th scope="col">Id</th>
				  <th scope="col">Fecha Inicial</th>				  
				  <th scope="col">Fecha Termino</th>
				  <th scope="col">Precio Oferta</th>
				  <th scope="col">Precio Normal</th>
				  <th scope="col">%</th>
				  <th scope="col">Stock</th>
				  <th scope="col"></th>
				</tr>
				</thead>
				<tbody id="tbody">

				@foreach ($ofertas as $oferta)
					<tr>
						<td>{{ $oferta->id }}</td>
						<td>{{ $oferta->fecha_inicio }}</td>
						<td>{{ $oferta->fecha_termino }}</td>
						<td>{{ $oferta->precio_oferta }}</td>
						<td>{{ $oferta->producto->precio_normal }}</td>
						<td>{{ round(100-(100/$oferta->producto->precio_normal)*$oferta->precio_oferta,2) }} %</td>
						<td>{{ $oferta->stock }}</td>
						<td width="110">
							<a href="{{ route('oferta.edit', [$oferta->id]) }}" class="btn btn-warning bt-sm" title="Editar producto"><i class="far fa-edit"></i></a>

							<button type="button" class="btn btn-danger bt-sm" onclick="modalEliminarOferta({{ $oferta->id }})"  title="Eliminar oferta"><i class="far fa-trash-alt"></i></button>
						</td>
					</tr>
				@endforeach

				</tbody>
			</table>
			
			<!-- Paginacion -->
			{{ $ofertas->links() }}

        </div>
    </div>


@include('oferta.modal.modalConfirmacionOferta')

<script type="text/javascript">
	
function modalEliminarOferta(id) {
    $('#idOfertaModalConfirmacion').val(id);
    $('#modalConfirmacionOferta').modal('show');
}

</script>


</div>


@endsection