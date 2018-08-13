<!DOCTYPE html>
<html>
<head>
	<title>{{ config('app.name', 'Ecommerce') }}</title>
	<script src="{{ asset('js/app.js') }}" defer></script>
	<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Icons-->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">

    
	<!-- Progress-Bar -->
	<link href="{{ asset('progress-bar/main.css') }}" rel="stylesheet">

</head>
<body>
	<div class="container">
		<div class="col-12">
			<div class="card" style="width: 30rem;">
			  <img class="card-img-top" src="{{ asset('img/email/banner.png') }}" alt="Card image cap">
			  <div class="card-body">
			  	<h2 class="card-title">Hola {{ $email->nombre_cliente }},</h2>
			  	<h3 class="card-title">Numero de orden: {{ $email->numero_orden }}</h3>
			    <h3 class="card-title">Estado pedido: {{ $email->asunto }}</h3>
			    <p class="card-text">
			    	Este es un email de prueba por el testing de envio.
			    </p>
			    <hr>
			    <div class="progress-bar-wrapper">
					<div class="status-bar" style="width: 75%;">
						<div class="current-status" style="width: 100%; transition: width 4500ms linear 0s;">
						</div>
					</div>
					<ul class="progress-bar">
						<!-- Estado Pago confirmado y orden de compra recibida -->
						<li class="section visited" style="width: 25%;">Solicitud Recibida</li>
						<!-- Orden de compra confirmada -->
						<li class="section visited" style="width: 25%;">Orden Confirmada</li>
						<!-- Orden Lista para retirar -->
						<li class="section visited" style="width: 25%;">Orden Lista para retirar</li>
						<!-- Orden entregada -->
						<li class="section visited current" style="width: 25%;">Orden entregada</li>
					</ul>
				</div>
			  </div>
			</div>
		</div>
	</div>
</body>
</html>