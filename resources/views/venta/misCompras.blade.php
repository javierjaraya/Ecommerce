@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('misCompras') }}
@endsection

@section('content')
<h4><b>Compras</b></h4>

@foreach ($mis_compras as $compra)
<div class="row mb-3">
	<div class="col-12">
	  <div class="card">
        <div class="card-body">
        	<div class="row">
        		<div class="col-12">
        			<div class="row">
        				<div class="col-6">
        					<h5><b>{{ $compra->estadoVenta->estado_venta }}</b></h5>
        				</div>
        				<div class="col-6 text-right">
        					<p>Compra realizada el {{ $compra->created_at }}</p>
        				</div>
        			</div>
        			<div class="row">
        				<div class="col-12">
        					<h6><b>Numero de orden: {{ $compra->id_venta }}</b></h6>
        				</div>
        			</div>
        		</div>
        	</div>
        	<div class='row'>
				<div class="col-10">
				@foreach ($compra->detalle as $detalle)
					<div class="row">
						<div class="col-2 mb-1">
							@if($detalle->producto->imagenes->get(0))
								@foreach ($detalle->producto->imagenes as $imagen)
									@if($imagen->es_principal == 1)
										<img src="{{ asset('storage/'.$imagen->ruta ) }}" height="60px" width="60px" class="img-thumbnail">		
									@endif								
								@endforeach
								
							@else
    							<img src="{{ asset('img/no-imagen.png') }}" height="40px" width="40px" class="img-thumbnail">
							@endif
						</div>
						<div class="col-10">
							{{ $detalle->producto->nombre }}<br>
							$ {{ number_format($detalle->precio) }} x {{ $detalle->cantidad }} unidad  
						</div>
					</div>
				@endforeach
				</div>
				<div class="col-2">
		        	<a href="{{ route('resumenVenta',[$compra->id_venta]) }}" class="btn btn-success">Ver detalle</a>
		        </div>
			</div>
	    </div>
	  </div>
	</div>
</div>
@endforeach

<!-- Paginacion -->
{{ $mis_compras->links() }}


@endsection