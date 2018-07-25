@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-6">
		@if($producto->imagenes->get(0))
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		  	<?php $i = 0; ?>
		  	@foreach ($producto->imagenes as $imagen)
		    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i++ }}" class="active"></li>
		    @endforeach
		  </ol>
		  <div class="carousel-inner">
		    <?php $i = 0; $active = "active"; ?>
		    @foreach ($producto->imagenes as $imagen)
		    @if ($i > 0)
				<?php $active = ""; ?>
			@endif
			<?php $i++; ?>
		    <div class="carousel-item {{ $active }}">
		      <img class="d-block w-100" src="{{ asset('storage/'.$imagen->ruta ) }}" alt="Second slide">
		    </div>
		    @endforeach
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Anterior</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Siguiente</span>
		  </a>
		</div>
		@else
		<img src="{{ asset('img/no-imagen.png') }}" class="rounded float-left" alt="Card image cap" width="100%">
		@endif
	</div>
	
	<div class="col-md-6">
		<div class="title">
			<h1>{{ $producto->nombre }}</h1>
			<h6>SKU {{ $producto->id }}</h6>
		</div>
		<div class="">
			@if ($producto->precio_oferta != null)
			<b style="font-size: 35px;">
				<span class="text-success">$ {{ number_format($oferta->precio_oferta) }}</span>
			</b>
			<span style="text-decoration: line-through; font-size: 17px;">$ {{ number_format($producto->precio_normal) }}</span>
			<hr>
			@else
			<b style="font-size: 35px;">
				<span class="text-success">$ {{ number_format($producto->precio_normal) }}</span>
			</b>
			<br>
			@endif
			
				
			{{ $producto->descripcion }}

		</div>

		<div class="">
			<form class="form-inline mt-3">
			@if ($producto->precio_oferta != null)
			<input type="number" class="form-control" min="0" max="{{ $oferta->stock }}" name="cantidad" value="1">
			@else
			<input type="number" class="form-control" min="0" max="{{ $producto->stock }}" name="cantidad" value="1">
			@endif
			<button type="button" class="btn btn-success ml-2"><i class="fas fa-shopping-cart"></i>  Añadir al carro</button>
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h5 class="mt-4"><b>Especificaciones</b></h5>
		<table class="table">
  		  <tbody>
  		  	@if ($especificaciones)
  		  	@foreach ($especificaciones as $especificacion)
				<tr>
			      <th scope="row">{{ $especificacion->nombre }}</th>
			      <td>{{ $especificacion->descripcion }}</td>
		    	</tr>
  		  	@endforeach
  		  	@else
  		  	Producto sin especificaciones
  		  	@endif
		  </tbody>
		</table>
	</div>
</div>





@endsection