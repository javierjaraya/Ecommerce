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
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Icons-->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">

    
	<!-- Progress-Bar -->
	<link href="{{ asset('progress-bar/main.css') }}" rel="stylesheet">

	<!-- Breadcrumbs -->
	<link href="{{ asset('css/breadcrumbs.css') }}" rel="stylesheet">


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
						<a href="{{ url('/') }}" class="nav-link">Home</a>
					</li>
					@guest
					@else
					    @if (Auth::user()->id_perfil == 1)
					    <li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Mis Compras</a>
							<div class="dropdown-menu">
								<a href="{{ route('misCompras') }}" class="dropdown-item">Estado de mis Compras</a>
							</div>
						</li>
					    @endif
						@if(Auth::user()->id_perfil == 2)
						<li class="nav-item">
							<a href="{{ route('producto.index') }}" class="nav-link">Productos</a>
						</li>
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Ventas</a>
							<div class="dropdown-menu">
						      <a href="{{ route('ventas',[1]) }}" class="dropdown-item">Ventas Anuladas</a>
						      <a href="{{ route('ventas',[2]) }}" class="dropdown-item">Con pago pendiente</a>
						      <a href="{{ route('ventas',[3]) }}" class="dropdown-item">Orden de Compra recibida</a>
						      <a href="{{ route('ventas',[4]) }}" class="dropdown-item">Confirmadas</a>
						      <a href="{{ route('ventas',[5]) }}" class="dropdown-item">Listas para retirar</a>
						      <a href="{{ route('ventas',[6]) }}" class="dropdown-item">Entregadas</a>
						    </div>
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
	                        	@if ($cliente == null || $cliente->nombres_razon_social == '')
	                        		{{ Auth::user()->email}} 
	                        	@else
	                        		{{ $cliente->nombres_razon_social.' '.$cliente->apellidos }} 
	                        	@endif

	                            <span class="caret"></span>
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
					<form action="{{ route('busqueda') }}" method="GET" class="form-inline  mt-4 pl-3">
					<div class="input-group ml-5">
						@if (isset($texto_buscar))
							<input type="text" class="form-control" placeholder="Buscar producto" aria-label="Buscar producto" aria-describedby="basic-addon2" name="texto_buscar" size="70" value="{{ $texto_buscar }}">
						@else
							<input type="text" class="form-control" placeholder="Buscar producto" aria-label="Buscar producto" aria-describedby="basic-addon2" name="texto_buscar" size="70" >
						@endif
					  	
						<select class="custom-select" id="" name="id_categoria">
							<option value="0" selected>Todas las categorias</option>
							@foreach ($categorias as $key => $categoria)
								@if(isset($id_categoria) && $id_categoria == $categoria->id)
									<option selected value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
								@else
									<option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
								@endif
							@endforeach
						</select>
						<div class="input-group-append">				  	
							<button class="btn btn-outline-secondary" type="submit">Buscar</button>
						</div>
					</div>
					</form>
				</div>

				<div class="col-lg-3">	
					<div class="mt-4 mb-3 pl-3">			
						<a href="{{ route('carroCompra') }}" class="btn btn-light btn-sm pt-2">
							<h4><i class="fas fa-shopping-cart"></i> <span class="badge badge-info">{{ $cantidad_total_carro }}</span> <span class="badge badge-secondary badge-light">Mi Carro $ {{ number_format($total_carro) }}</span></h4>
						</a>
					</div>				
				</div>

				</div>
				
			</div>
		</header>
		<div class="container-fluid">
			<div class="row">
				<!-- Div ASIDE-->
				<div class="col-sm-4 col-md-3 col-lg-2">				
					<aside class="mb-3">
					
						<div id="MainMenu">
						  <div class="list-group">
						    <label class="list-group-item list-group-item-light collapsed text-light bg-dark" data-toggle="collapse" ><b>CATEGORIAS</b></label>
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
				</div><!-- Fin Div ASIDE --!>

				<!-- Div Contenido Pagina-->
				<div class=" col-sm-8 col-md-9 col-lg-10">
					<section>
		                @yield('breadcrumbs')
		            </section>
		            
					<section class="pb-3">					

					@yield('content')


					</section>
				</div><!-- Fin Div Contenido Pagina -->
			</div>
		</div>

		<footer class="footer text-light bg-dark">
			<div class='container'> 
				<div class="row">
					<div class="col-md-4 p-3">
						<b>Sobre Nosotros</b>
						<br>
						<a href="#"><i class="fas fa-angle-right"></i> Quienes somos</a><br>
						<a href="#"><i class="fas fa-angle-right"></i> Metodos de envio</a><br>
						<a href="#"><i class="fas fa-angle-right"></i> Formas de pago</a><br>
						<a href="#"><i class="fas fa-angle-right"></i> Centro de ayuda</a><br>
					</div>
					<div class="col-md-4 p-3">
						<div>
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3202.79390704764!2d-72.09505748504351!3d-36.60727237998876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x966929d542df3bd3%3A0xe7b440326d9bae25!2zQXJnZW50aW5hIDQwNiwgQ2hpbGxhbiwgQ2hpbGzDoW4sIFJlZ2nDs24gZGVsIELDrW8gQsOtbw!5e0!3m2!1ses!2scl!4v1532547612498" width="300" height="170" frameborder="0" style="border:0" allowfullscreen></iframe>
						</div>
					</div>
					<div class="col-md-4 p-3">
						<div>
							<b>Contacto</b>
							<br>
							<i class="fas fa-phone"></i>
							(42) 225 2161
							<br>
							<i class="fas fa-envelope"></i>
							direcciondecorreo@web.com
							<br>
							<i class="fas fa-map-marker"></i>
							Av. Argentina 406, Chillán, Chile
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
</body>
</html>