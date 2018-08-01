@extends('layouts.app')

@section('content')
	<div class="row">
		@include('venta.fragment.error')
		@include('venta.fragment.success')
		<div class="col-sm-12 mb-3">
			<div class="card">
			  <div class="card-header">
			    Resumen Venta
			  </div>
			  <div class="card-body">
				<div class="row">
					<div class="col-sm-6">
						Numero de orden:<br>
						<b>00000000{{ $venta->id_venta }}</b>
					</div>
					<div class="col-sm-6 text-right">
						<b>Total: $ {{ number_format($totalVenta) }}</b><br>
						<h6>Fecha de compra: {{ $venta->created_at }}</h6>
					</div>
				</div>
				<hr>

				<div class="row">
					<div class="col-sm-12 p-4">
						@if (isset($detalleVenta))
							<h4>{{ $venta->tipoDespacho->tipo_despacho }}</h4>
							@foreach ($detalleVenta as $detalle)
							<div class="row">
								<div class="col-6 col-sm-4 col-md-2">
								@foreach ($detalle->producto->imagenes as $key => $imagen)
							  		@if ($imagen->es_principal == 1)
							  			<img src="{{ asset('storage/'.$imagen->ruta) }}" width="100%">
							  		@endif
							  	@endforeach
							    </div>
								<div class="col-6 col-sm-6 col-md-10 pt-4">
									{{ $detalle->producto->nombre }}<br>
									$ {{ number_format($detalle->precio) }}<br>
									{{ $detalle->cantidad }} Unidad<br>
								</div>
							</div>
							@endforeach
						@else
							<h5>No hay registro de una venta</h5>
						@endif
					</div>

				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="row mt-5">
							<div class="col-sm-12 pl-5 pr-5">
								<div class="progress ml-4 mr-4">
								  <div class="progress-bar w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
						
						<div class="row mb-5">
							<div class="col-sm-3">
								Solicitud recibida
							</div>
							<div class="col-sm-3">
								Orden confirmada
							</div>
							<div class="col-sm-3">
								Orden lista para retirar
							</div>
							<div class="col-sm-3 text-right">
								Orden entregada
							</div>
						</div>
					</div>
				</div>


			  </div>
			</div>

		</div>
	</div>
@endsection