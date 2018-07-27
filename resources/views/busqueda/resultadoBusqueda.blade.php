@extends('layouts.app')

@section('content')

		@include('busqueda.fragment.error')
		@include('busqueda.fragment.success')

		<div class="row">
        @foreach ($productos as $producto)
        <div class="col-3">
			<div class="card mb-3" style="">
				<div class="card-title text-right pr-1 mb-1">
					<span class="badge badge-success">
						@if (isset($producto->precio_oferta))
							Oferta {{ round(100-(100/$producto->precio_normal)*$producto->precio_oferta,0) }} %
						@else
							Disponible
						@endif

			    	</span>
			    </div>
			    <a href="{{ route('producto.show', [$producto->id_producto] ) }}">
					@if($producto->ruta)
						<img class="card-img-top" src="{{ asset('storage/'.$producto->ruta) }}" alt="Card image cap">
					@else
						<img sr	c="{{ asset('img/no-imagen.png') }}" class="card-img-top" alt="Card image cap">
					@endif
				</a>
			  	
			  <div class="card-body">
			    <h5 class="card-title text-center"><a  href="{{ route('producto.show', [$producto->id_producto] ) }}">{{ $producto->nombre }}</a> 
			    </h5>
			    <p class="card-text text-center">
			    	@if (isset($producto->precio_oferta))
			    	<b style="font-size: 15px;">
			    		<span class="text-success">$ {{ number_format($producto->precio_oferta) }}</span>
			    	</b>
			    	<span style="text-decoration: line-through; font-size: 10px;">$ {{ number_format($producto->precio_normal) }}</span>
					@else
						<b style="font-size: 15px;">
			    		<span class="text-success">$ {{ number_format($producto->precio_normal) }}</span>
			    	</b>
					@endif
			    </p>
			  </div>
			</div>
		</div>
        @endforeach
        </div>
@endsection