@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12 mb-2">

		<h3>Carrito de compra</h3>
		<table class="table">
			<thead class="thead-dark">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Producto</th>
			  <th scope="col">Precio</th>
			  <th scope="col">Cantidad</th>
			  <th scope="col">Total</th>
			</tr>
			</thead>
			<tbody>
				@if (count($detalle_carro) == 0)
					<tr>
						<th> Carro vacio</th>
					</tr>
				@else
				@foreach ($detalle_carro as $detalle)
					<tr>
					  <th scope="row">
					  	@foreach ($detalle->producto->imagenes as $key => $imagen)
					  		@if ($imagen->es_principal == 1)
					  			<img src="{{ asset('storage/'.$imagen->ruta) }}" height="50px" width="50px">
					  		@endif
					  	@endforeach
					  </th>
					  <td>{{ $detalle->producto->nombre }}</td>
					  <td>
						<b><span class="text-success">$ {{ number_format($detalle->precio) }}</span></b>
						@if ($detalle->precio < $detalle->producto->precio_normal)
							<br><span style="text-decoration: line-through; font-size: 11px;">$ {{ number_format($detalle->producto->precio_normal) }}</span>
						@endif
					  </td>
					  <td style="">
					  	<form action="{{ route('detalleCarroUpdate',[$detalle->id_detalle_carro]) }}" method="POST">
					@csrf
                    @method('PUT')
					  	<input type="hidden" name="id_carro_compra" value="{{ $detalle->id_carro_compra }}">
					  	<input type="hidden" name="id_detalle_carro" value="{{ $detalle->id_detalle_carro }}">
					  	<input type="number" id="cantidad_{{ $key }}" name="cantidad" min="0" max="{{ $detalle->producto->stock }}" value="{{ $detalle->cantidad }}" onchange="this.form.submit()">
					  	</form>
					  </td>
					  <td>
					  	<form action="{{ route('detalleCarroDestroy',[$detalle->id_detalle_carro]) }}" class="form-inline" method="POST">
					  		@csrf
					  		@method('DELETE')
                    		<span id="total_{{ $key }}">$ {{ number_format($detalle->precio*$detalle->cantidad) }}</span>
					  		<button type="submit" class="btn btn-link"><i class="far fa-trash-alt"></i></button>
					  	</form>
					  </td>
					</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12 mb-3 pr-5">
		<a href="{{ url('/') }}" class="btn btn-success float-left text-light"><i class="fas fa-chevron-left"></i>  Seguir comprando</a>
		@if (count($detalle_carro) == 0)
			<button class="btn btn-success float-right" disabled><i class="fas fa-dollar-sign"></i>  Pasar por caja</button>
		@else
			<a href="{{ route('caja') }}" class="btn btn-success float-right"><i class="fas fa-dollar-sign"></i>  Pasar por caja</a>
		@endif
	</div>
</div>

<script type="text/javascript">
	
	
</script>


@endsection