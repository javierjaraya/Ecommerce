@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-8"> 
		<form action="{{ route('pagar') }}" method="POST" class="needs-validation" novalidate>
		@csrf
			<div class="card">
			  <div class="card-header">
			    <b>Primer Paso - Datos envío</b>
			  </div>
			  <div class="card-body" id="datosEnvio">
			    	<div class="form-group row">
				    <label for="rut_retira" class="col-sm-2 col-form-label">Rut</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="rut_retira" name="rut_retira" placeholder="Rut" value="{{ $cliente->rut }}" required>
				      <div class="invalid-feedback">
				        Por favor ingrese su rut
				      </div>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="nombre_retira" class="col-sm-2 col-form-label">Nombre</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="nombre_retira" name="nombre_retira" placeholder="Nombre" value="{{ $cliente->nombres_razon_social }}" required>
				      <div class="invalid-feedback">
				        Por favor ingrese su nombre o razon social
				      </div>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="apellido_retira" class="col-sm-2 col-form-label">Apellidos</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="apellido_retira" name="apellido_retira" placeholder="Apellidos" value="{{ $cliente->apellidos }}" required>
				      <div class="invalid-feedback">
				        Por favor ingrese sus apellidos
				      </div>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="direccion_retira" class="col-sm-2 col-form-label">Dirección</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="direccion_retira" name="direccion_retira" placeholder="Dirección" value="{{ $cliente->direccion }}" required>
				      <div class="invalid-feedback">
				        Por favor ingrese su direccion
				      </div>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="telefono_retira" class="col-sm-2 col-form-label">Telefono</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="telefono_retira" name="telefono_retira" placeholder="Telefono" value="{{ $cliente->contacto }}" required>
				      <div class="invalid-feedback">
				        Por favor ingrese su numero de telefono
				      </div>
				    </div>
				  </div>
			  </div>
			</div>

			<div class="card">
			  <div class="card-header">
			    <b>Segundo Paso - Método de envío</b>
			  </div>
			  <div class="card-body" id="metodoDespacho">
			    <div class="form-check">
				  <input class="form-check-input" type="radio" name="id_tipo_despacho" id="radio1" value="1" required>
				  <label class="form-check-label" for="radio1">
				    Despacho a domicilio (Por pagar)
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="id_tipo_despacho" id="radio2" value="2">
				  <label class="form-check-label" for="radio2">
				    Retiro en tienda (Gratis)
				  </label>
				  <div class="invalid-feedback">
			        Por favor seleccione el método de despacho.
			      </div>
				</div>
				<div class="form-group mt-3">
				    <label for="comentario_despacho">Si desea dejarnos un comentario acerca de su pedido, por favor, escríbalo a continuación.</label>
	    			<textarea class="form-control" id="comentario_despacho" name="comentario_despacho" rows="3"></textarea>
				  </div>
			  </div>
			</div>

			<div class="card mb-3">
			  <div class="card-header">
			    <b>Ultimo Paso - Medio de Pago</b>
			  </div>
			  <div class="card-body" id="medioPago">
			    <div class="form-check">
				  <input class="form-check-input" type="radio" name="id_medio_pago" id="radio3" value="1" required>
				  <label class="form-check-label" for="radio3">
				    Webpay Plus
				    <img src="{{ asset('img/webpay.png') }}" width="60px" height="">
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="id_medio_pago" id="radio4" value="2">
				  <label class="form-check-label" for="radio4">
				    PayPal
				    <img src="{{ asset('img/paypal.png') }}" width="60px" height="">
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="id_medio_pago" id="radio5" value="3">
				  <label class="form-check-label" for="radio5">
				    Pago por transferencia bancaria
				  </label>
				  <div class="invalid-feedback">
			        Por favor seleccione un medio de pago.
			      </div>
				</div>
				<br>
				<input type="submit" class="btn btn-primary" style="width: 100%;" value="Pagar">
			  </div>
			</div>
		</form>
	</div>

	<div class="col-md-4 mb-3">
		<div class="card">
		  <div class="card-header">
		    <b>Resumen</b>
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


<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

@endsection
