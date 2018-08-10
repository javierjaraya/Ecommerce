@extends('layouts.app')

@section('content')




	<div class="row">

		<div class="col-sm-12 mb-3">
			<div class="card">
			  <div class="card-header">
			    Resumen Venta
			  </div>
			  <div class="card-body">
				@include('venta.fragment.error')
				@include('venta.fragment.success')
				@include('venta.fragment.info')

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
				<hr>
				<div class="row">
					<div class="col-sm-12">
						<h4>Cliente</h4><br>
						<form>
						  <div class="form-row">
						    <div class="form-group col-md-4">
						      <label for="rut">Rut</label>
						      <input type="text" class="form-control-plaintext" id="rut" placeholder="{{ $cliente->rut }}" readonly>
						    </div>
						    <div class="form-group col-md-4">
						      <label for="nomnre_rason_social">Nombre o razon social</label>
						      <input type="password" class="form-control-plaintext" id="nomnre_rason_social" placeholder="{{ $cliente->nombres_razon_social }}" readonly>
						    </div>
						    <div class="form-group col-md-4">
							  <label for="apellidos">Apellidos</label>
							  <input type="text" class="form-control-plaintext" id="apellidos" placeholder="{{ $cliente->apellidos }}" readonly>
							</div>
						  </div>
						  
						  <div class="form-row">
						  	<div class="form-group col-md-8">
							    <label for="direccion">Direccion</label>
							    <input type="text" class="form-control-plaintext" id="direccion" placeholder="{{ $cliente->direccion }}" readonly>
							  </div>
						    <div class="form-group col-md-4">
						      <label for="contacto">Contacto</label>
						      <input type="text" class="form-control-plaintext" id="contacto" placeholder="{{ $cliente->contacto }}" readonly>
						    </div>
						  </div>
						</form>
					</div>
				</div>

				<hr>
				
				<div class="row">
					<div class="col-sm-12">
						<h4>Persona Retira</h4><br>
						<form>
						  <div class="form-row">
						    <div class="form-group col-md-4">
						      <label for="rut_retira">Rut</label>
						      <input type="text" class="form-control-plaintext" id="rut_retira" placeholder="{{ $venta->rut_retira }}" readonly>
						    </div>
						    <div class="form-group col-md-4">
						      <label for="nombre_retira">Nombre</label>
						      <input type="text" class="form-control-plaintext" id="nombre_retira" placeholder="{{ $venta->nombre_retira }}" readonly>
						    </div>
						    <div class="form-group col-md-4">
							  <label for="apellido_retira">Apellidos</label>
							  <input type="text" class="form-control-plaintext" id="apellido_retira" placeholder="{{ $venta->apellido_retira }}" readonly>
							</div>
						  </div>
						  
						  <div class="form-row">
						  	<div class="form-group col-md-8">
							  <label for="direccion_retira">Direccion</label>
							  <input type="text" class="form-control-plaintext" id="direccion_retira" placeholder="{{ $venta->direccion_retira }}" readonly>
							</div>
						    <div class="form-group col-md-4">
						      <label for="telefono_retira">Contacto</label>
						      <input type="text" class="form-control-plaintext" id="telefono_retira" placeholder="{{ $venta->telefono_retira }}" readonly>
						    </div>
						  </div>

						  <div class="form-row">
						  	<div class="form-group col-md-12">
						  		<label for="comentario_despacho">Comentario Despacho</label>
							  <input type="text" class="form-control-plaintext" id="comentario_despacho" placeholder="{{ $venta->comentario_despacho }}" readonly>
						  	</div>
						  </div>
						</form>
					</div>
				</div>

			  </div>


			  <div class="card-footer text-muted">
			    <div class="row">
					<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-1">
						@if($venta->id_estado_venta == 2)
						<a href="{{ route('confirmarPago',[$venta->id_venta]) }}" class="btn btn-success text-light"><i class="fas fa-hand-holding-usd"></i>  Confirmar Pago</a>
						@else
						<a href="#" class="btn btn-success text-light disabled "><i class="fas fa-hand-holding-usd"></i>  Confirmar Pago</a>
						@endif
					</div>

					<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-1">
						<a href="{{ route('confirmarOrden',[$venta->id_venta]) }}" class="btn btn-light"><i class="fas fa-clipboard-check"></i>  Confirmar Orden</a>
					</div>

					<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-1">
						<a href="{{ route('listaParaRetirar',[$venta->id_venta]) }}" class="btn btn-light"><i class="fas fa-luggage-cart"></i>  Lista para retirar</a>
					</div>

					<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-1">
						<a href="{{ route('compraEntregada',[$venta->id_venta]) }}" class="btn btn-light"><i class="fas fa-people-carry"></i>  Compra entregada</a>
					</div>

					<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-1">
						<a href="{{ route('anularCompra',[$venta->id_venta]) }}" class="btn btn-danger text-light"><i class="fas fa-ban"></i>  Anular Compra</a>
					</div>

				</div>
			  </div>
			</div>

		</div>
	</div>

@endsection