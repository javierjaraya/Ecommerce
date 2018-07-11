<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href={{ asset('img/favicon.ico') }} />

    <title>{{ config('app.name', 'Ecommerce') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light bg-light navbar-dark bg-dark" >		
		<div class="container">
			<a class="navbar-brand" href="#">
		      <img src="{{ asset('img/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
		      Ecommerce
		    </a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">

				<form class="form-inline col-12 col-lg-5 col-xl-6 my-2 my-lg-0">
			 		<input class="form-control col-9 col-lg-8 col-xl-9 mr-2 mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
			 		<button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Buscar</button>
				</form>

			<ul class="navbar-nav ml-auto">
			  <li class="nav-item active">
			    <a class="nav-link" href="#">Iniciar Sesión</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="#">Registrarme</a>
			  </li>
			  <li class="nav-item dropdown">
			    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			      Carro de Compra
			    </a>
			    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			      <a class="dropdown-item" href="#">Ver carro de compra</a>
			      <a class="dropdown-item" href="#">Pagar</a>
			      <div class="dropdown-divider"></div>
			      <a class="dropdown-item" href="#">Vaciar carro de compra</a>
			    </div>
			  </li>
			</ul>
			
			</div>
		</div>	
			
		</nav>
	</div>
</body>
</html>