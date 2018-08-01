@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-8"> 

		<div class="card" onclick="datosEnvio()">
		  <div class="card-header">
		    Primer Paso - Datos envío
		  </div>
		  <div class="card-body" id="datosEnvio">
		    <form>
		    	<div class="form-group row">
			    <label for="inputRut" class="col-sm-2 col-form-label">Rut</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="inputRut" name="rut" placeholder="Rut" value="{{ $cliente->rut }}">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="inputNombre" name="nombre" placeholder="Nombre" value="{{ $cliente->nombres_rason_social }}">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="inputApellidos" class="col-sm-2 col-form-label">Apellidos</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="inputApellidos" name="apellidos" placeholder="Apellidos" value="{{ $cliente->apellidos }}">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="inputDireccion" class="col-sm-2 col-form-label">Dirección</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="inputDireccion" name="direccion" placeholder="Dirección" value="{{ $cliente->direccion }}">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="inputTelefono" class="col-sm-2 col-form-label">Telefono</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="Telefono" value="{{ $cliente->contacto }}">
			    </div>
			  </div>
			    <button type="submit" class="btn btn-primary" style="width: 100%;">Continuar</button>
			</form>
		  </div>
		</div>

		<div class="card" onclick="metodoDespacho()">
		  <div class="card-header">
		    Segundo Paso - Método de envío
		  </div>
		  <div class="card-body" id="metodoDespacho" style="display: none;">
		    <div class="form-check">
			  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
			  <label class="form-check-label" for="exampleRadios1">
			    Despacho a domicilio
			  </label>
			</div>
			<div class="form-check">
			  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
			  <label class="form-check-label" for="exampleRadios2">
			    Retiro en tienda
			  </label>
			</div>
			<div class="form-group mt-3">
			    <label for="comentario_envio">Si desea dejarnos un comentario acerca de su pedido, por favor, escríbalo a continuación.</label>
    			<textarea class="form-control" id="comentario_envio" rows="3"></textarea>
			  </div>
			<button type="submit" class="btn btn-primary" style="width: 100%;">Continuar</button>
		  </div>
		</div>

		<div class="card mb-3" onclick="medioPago()">
		  <div class="card-header">
		    Ultimo Paso - Medio de Pago
		  </div>
		  <div class="card-body" id="medioPago" style="display: none;">
		    <div class="form-check">
			  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1">
			  <label class="form-check-label" for="exampleRadios1">
			    Webpay Plus
			  </label>
			</div>
			<div class="form-check">
			  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1">
			  <label class="form-check-label" for="exampleRadios1">
			    PayPal
			  </label>
			</div>
			<div class="form-check">
			  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
			  <label class="form-check-label" for="exampleRadios2">
			    Pago por transferencia bancaria
			  </label>
			</div>
			<br>
			<button type="submit" class="btn btn-primary" style="width: 100%;">Comprar</button>
		  </div>
		</div>

		
	</div>

	<div class="col-md-4 mb-3">
		<div class="card">
		  <div class="card-header">
		    Resumen
		  </div>
		  <div class="card-body">
		  	<?php $total = 0; ?>
		  	@foreach ($detalle_carro as $detalle)
			<div class="row">
			<div class="col-sm-2">
			@foreach ($detalle->producto->imagenes as $key => $imagen)
		  		@if ($imagen->es_principal == 1)
		  		    <a href="{{ route('producto.show', [$detalle->producto->id] ) }}">
		  			<img src="{{ asset('storage/'.$imagen->ruta) }}" height="50px" width="50px">
		  		    </a>
		  		@endif
		  	@endforeach
		  	</div>
		  	<div class="col-sm-10">
		  		<h6><a href="{{ route('producto.show', [$detalle->producto->id] ) }}">{{ $detalle->producto->nombre }}</a></h6>
		  		<p class="text-right">{{ $detalle->cantidad }} x ${{ number_format($detalle->precio) }}</p>
		  		<?php $total += $detalle->cantidad*$detalle->precio; ?>
		  	</div>
		  	</div>
		  	@endforeach
		  	<div class="row">
		  		<div class="col-sm-12 text-right">
		  			<hr>
		  			<h6>SubTotal: ${{ number_format($total-$total*0.19) }}</h6>
		  			<h6>iva 19%: ${{ number_format($total*0.19) }}</h6>
		  			<hr>
					<h5><b>Total ${{ number_format($total) }}</b></h5>
		  		</div>
		  	</div>
		  </div>
		</div>
	</div>



</div>


<script type="text/javascript">
	

	function datosEnvio(){
		$("#datosEnvio").show();
		$("#metodoDespacho").hide();
		$("#medioPago").hide();
	}

	function metodoDespacho(){
		$("#datosEnvio").hide();
		$("#metodoDespacho").show();
		$("#medioPago").hide();
	}

	function medioPago(){
		$("#datosEnvio").hide();
		$("#metodoDespacho").hide();
		$("#medioPago").show();
	}
</script>

@endsection
