@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-6">
		
		@if($producto->imagenes->get(0) && false)
			@foreach ($producto->imagenes as $imagen)
				@if($imagen->es_principal == 1)
					<img src="{{ asset('storage/'.$imagen->ruta ) }}" class="rounded float-left" alt="Card image cap" width="100%">
				@endif								
			@endforeach
			
		@else
			@if (false)
			<img src="{{ asset('img/no-imagen.png') }}" class="rounded float-left" alt="Card image cap" width="100%">
			@endif
		@endif

		<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">    
            <div class="rg-image-wrapper">

                    <div class="rg-image-nav">
                        <a href="#" class="rg-image-nav-prev">Previous Image</a>
                        <a href="#" class="rg-image-nav-next">Next Image</a>
                    </div>

                <div class="rg-image"></div>
                <div class="rg-loading"></div>
                <div class="rg-caption-wrapper">
                    <div class="rg-caption" style="display:none;">
                        <p></p>
                    </div>
                </div>
            </div>
        </script>

		<div id="rg-gallery" class="rg-gallery">
		    <div class="rg-thumbs">
		        <!-- Elastislide Carousel Thumbnail Viewer -->
		        <div class="es-carousel-wrapper">
		            <div class="es-carousel">
		                <ul>

							@if($producto->imagenes->get(0))
								@foreach ($producto->imagenes as $imagen)
									<li><a href="#"><img src="{{ asset('storage/thumbs/'.$imagen->ruta ) }}" data-large="{{ asset('storage/'.$imagen->ruta ) }}" alt="" data-description="" /></a></li>
								@endforeach
							@else
								<img src="{{ asset('img/no-imagen.png') }}" class="rounded float-left" alt="Card image cap" width="100%">
							@endif
		                    
		                </ul>
		            </div>
		            <div class="es-nav">
		                <span class="es-nav-prev">Anterior</span>
		                <span class="es-nav-next">Siguiente</span>
		            </div>
		        </div>
		        <!-- End Elastislide Carousel Thumbnail Viewer -->
		    </div><!-- rg-thumbs -->
		</div><!-- rg-gallery -->

		</div>
	
	<div class="col-md-6">
		<div class="title">
			<h1>{{ $producto->nombre }}</h1>
			<h6>SKU {{ $producto->id }}</h6>
		</div>
		<div class="">
			<b style="font-size: 35px;">
				<span class="text-success">$ {{ number_format($oferta->precio_oferta) }}</span>
			</b>
			<span style="text-decoration: line-through; font-size: 17px;">$ {{ number_format($producto->precio_normal) }}</span>
			<hr>
			{{ $producto->descripcion }}

		</div>

		<div class="">
			<form class="form-inline mt-3">

			<input type="number" class="form-control" min="0" max="{{ $oferta->stock }}" name="cantidad" value="1">
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