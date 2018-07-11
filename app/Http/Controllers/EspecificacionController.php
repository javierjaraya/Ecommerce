<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EspecificacionRequest;//Para la validacion
use App\Especificacion;

class EspecificacionController extends Controller {


    public function store(EspecificacionRequest $especificacionRequest){
    	
    	$newEspecificacion = Especificacion::create($especificacionRequest->all());
		$id = $newEspecificacion->id_producto;

    	return redirect()->route('producto.edit',$id)->with('success','Especificacion agregada correctamente.');
	}

	public function editModal(EspecificacionRequest $especificacionRequest){

		$especificacion = Especificacion::find($especificacionRequest->id);
		$especificacion->update($especificacionRequest->all());
		return array(
			'success' => 'Especificación actualizada correctamente', 
		);
	}

	public function removeModal(Request $requeest){
		$especificacion = Especificacion::find($requeest->id);
    	$especificacion->delete();
    	return array(
			'success' => 'Especificación eliminada correctamente', 
		);
	}
}
