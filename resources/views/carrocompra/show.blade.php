@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">

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
					  			<img src="{{ asset('storage/'.$imagen->ruta) }}" height="45px" width="45px">
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
					  	<input type="number" id="cantidad_{{ $key }}" name="cantidad" min="0" max="{{ $detalle->producto->stock }}" value="{{ $detalle->cantidad }}" onchange="actualizarPrecio('total_{{ $key }}',this.value,{{ $detalle->precio }})">
					  </td>
					  <td id="total_{{ $key }}">$ {{ number_format($detalle->precio*$detalle->cantidad) }}</td>
					</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	
	function actualizarPrecio($td_total,$cantidad,$precio){
		$("#"+$td_total).html("$ "+number_format($cantidad*$precio),0);
		//Actualizarlo a nivel de BD - Pendiente
	}

	function number_format(amount, decimals) {
	    amount += ''; // por si pasan un numero en vez de un string
	    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

	    decimals = decimals || 0; // por si la variable no fue fue pasada

	    // si no es un numero o es igual a cero retorno el mismo cero
	    if (isNaN(amount) || amount === 0) 
	        return parseFloat(0).toFixed(decimals);

	    // si es mayor o menor que cero retorno el valor formateado como numero
	    amount = '' + amount.toFixed(decimals);

	    var amount_parts = amount.split('.'),
	        regexp = /(\d+)(\d{3})/;

	    while (regexp.test(amount_parts[0]))
	        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

	    return amount_parts.join('.');
	}
</script>


@endsection