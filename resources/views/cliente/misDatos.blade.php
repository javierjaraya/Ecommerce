@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Mis Datos</div>

                <div class="card-body">                	
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
	
					<!-- FORMULARIO MIS DATOS-->
					@include('cliente.fragment.error')
					@include('cliente.fragment.success')
					<form action="{{ route('cliente.update',$cliente->id) }}" method="POST">
						@csrf
						@method('PUT')
						<input type="hidden" class="form-control" id="id" name="id" value="{{ $cliente->id }}" >
						<input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="{{ Auth::user()->id }}" >
						<div class="form-group row">
							<label for="rut" class="col-sm-3 col-form-label">Rut</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="rut" name="rut" placeholder="Rut" value="{{ $cliente->rut }}">
							</div>
						</div>
						<div class="form-group row">
							<label for="nombres_rason_social" class="col-sm-3 col-form-label">Nombre o rason social</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="nombres_rason_social" name="nombres_rason_social" placeholder="Nombre o rason social" value="{{ $cliente->nombres_rason_social }}">
							</div>
						</div>
						<div class="form-group row">
							<label for="apellidos" class="col-sm-3 col-form-label">Apellidos</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{ $cliente->apellidos }}">
							</div>
						</div>

						<div class="form-group row">
							<label for="giro" class="col-sm-3 col-form-label">Giro</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="giro" name="giro" placeholder="Giro" value="{{ $cliente->giro }}">
							</div>
						</div>

						<div class="form-group row">
							<label for="contacto" class="col-sm-3 col-form-label">Contacto</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="contacto" name="contacto" placeholder="Contacto" value="{{ $cliente->contacto }}">
							</div>
						</div>

						<div class="form-group row">
							<label for="direccion" class="col-sm-3 col-form-label">Dirección</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="{{ $cliente->direccion }}">
							</div>
						</div>

						<div class="form-group row">
							<label for="id_comuna" class="col-sm-3 col-form-label">Comuna</label>
							<div class="col-sm-9">
								<select class="js-example-basic-single form-control " id="id_comuna" name="id_comuna">
									@foreach ($comunas as $comuna)	
									@if($comuna->comuna_id == $cliente->id_comuna )
									    <option value="{{ $comuna->comuna_id }}" selected>{{ $comuna->comuna_nombre }}</option>
									@else
									    <option value="{{ $comuna->comuna_id }}">{{ $comuna->comuna_nombre }}</option>
									@endif						
									@endforeach	
								</select>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary">Guardar cambios</button>
							</div>
						</div>
					</form> 
					<!-- END FORMULARIO MIS DATOS-->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
    $('#id_comuna').select2();
});
</script>

@endsection