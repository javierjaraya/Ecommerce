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

    <!-- Scripts ESTA COMENTADO PARA PROBAR EL SELECT DE COMUNA EN MIS DATOS-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

	<!-- Scripts para la galeria de fotos-->
    <script type="text/javascript" src="{{ asset('js/galeria/jquery.tmpl.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/galeria/jquery.easing.1.3.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/galeria/jquery.elastislide.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/galeria/gallery.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Icons-->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">

	<!-- CSS Galeria -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/galeria/reset.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/galeria/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/galeria/elastislide.css') }}" />
	<noscript>
        <style>
            .es-carousel ul{
                display:block;
            }
        </style>
    </noscript>
        



<!-- PARA EL SELECT DE COMUNA Jquery da comflicto-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>	-->


</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light bg-light navbar-dark bg-dark" >		
			<div class="container">
				<a class="navbar-brand" href="{{ url('/') }}">
			      <img src="{{ asset('img/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
			      {{ config('app.name', 'Ecommerce') }}
			    </a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link active">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link">Ubicación</a>
					</li>
					<li class="nav-item">
						<a class="nav-link">Contacto</a>
					</li>
					@guest
					@else
						@if(Auth::user()->id_perfil == 2)
						<li class="nav-item">
							<a href="{{ route('producto.index') }}" class="nav-link">Productos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link">Ventas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link">Ventas Anuladas</a>
						</li>
						@endif	
					@endguest
				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ml-auto">
					<!-- Authentication Links -->
					@guest
						<li class="nav-item active">
					    	<a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
						</li>
						<li class="nav-item">
					    	<a class="nav-link" href="{{ route('register') }}">Registrarme</a>
						</li>
				  	@else
				  		<li class="nav-item dropdown">
	                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
	                            {{ Auth::user()->email }} <span class="caret"></span>
	                        </a>

	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
	                            <a class="dropdown-item" href="{{ route('logout') }}"
	                               onclick="event.preventDefault();
	                                             document.getElementById('logout-form').submit();">
	                                {{ __('Cerrar Session') }}
	                            </a>
	                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                @csrf
	                            </form>
	                            <a class="dropdown-item" href="{{ route('misdatos') }}">Mis datos</a>
	                        </div>
	                    </li>
	                @endguest
				</ul>
				
				</div>
			</div>	
		</nav>
		<header>
			<div class="container">
				<div class="row">
					
				<div class="col-12 col-lg-9">
					<div class="input-group mt-4 pl-3">
					<input type="text" class="form-control" placeholder="Buscar producto" aria-label="Buscar producto" aria-describedby="basic-addon2">
					<select class="custom-select" id="inputGroupSelect01">
						<option selected>Todas las categorias</option>
						<option value="1">Repuestos</option>
						<option value="2">Vestuario</option>
						<option value="3">Bicicletas</option>
					</select>
					<div class="input-group-append">				  	
						<button class="btn btn-outline-secondary" type="button">Buscar</button>
					</div>
					</div>
				</div>

				<div class="col-lg-3">	
					<div class="mt-4 mb-3 pl-3">						
						<button type="button" class="btn btn-light btn-sm pt-2">
							<h4><i class="fas fa-shopping-cart"></i> <span class="badge badge-info">0</span> <span class="badge badge-secondary badge-light">Mi Carro $ 0</span></h4>
						</button>
					</div>				
				</div>

				</div>
				
			</div>
		</header>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2 col-md-2">				
					<aside>
					
						<div id="MainMenu">
						  <div class="list-group">
						    
							@foreach ($categorias as $key => $categoria)
							<a href="#menu{{ $key }}" class="list-group-item list-group-item-light collapsed" data-toggle="collapse" data-parent="#MainMenu">{{ $categoria->nombre }}</a>
						    <div class="collapse" id="menu{{ $key }}">
						    	@foreach ($categoria->subcategorias as $i => $subcategoria)
									<a href="{{ route('productoSubCategoria',[$subcategoria->id]) }}" class="list-group-item">{{ $subcategoria->nombre }}</a>
						    	@endforeach
						    </div>
							@endforeach

						    
						  </div>
						</div>

					</aside>
				</div>
				<div class=" col-sm-10 co-md-10">
					<section>					

					@yield('content')


					</section>
				</div>
			</div>
		</div>

		<footer class="footer footer-black">
			
		</footer>
	</div>
</body>
</html>