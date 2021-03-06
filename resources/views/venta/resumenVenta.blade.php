@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('resumenVenta',$venta) }}
@endsection

@section('content')
	<div class="row">
		@include('venta.fragment.error')
		@include('venta.fragment.success')
		@include('venta.fragment.info')
		<div class="col-sm-12">
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
					<div class="col-sm-12">
						@include('venta.fragment.progress-bar')
					</div>
				</div>

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
									SKU {{ $detalle->producto->id }}<br>
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

				@if ($venta->id_estado_venta == 2 || $venta->id_estado_venta == 1)
					<div class="row">
						@include('venta.fragment.infoTransferencia')
					</div>
				@else
					<div class="row mb-3">
						<div class="col-12 text-center">
							<img src="{{ asset('img/ok.png') }}" width="80rem;">
							<h1>Pago Aprobado</h1>
						</div>
					</div>
				@endif

			  </div>
			</div>

		</div>
	</div>
@endsection