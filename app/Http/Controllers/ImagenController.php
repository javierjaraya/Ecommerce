<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;//para acceder a la bd
use App\Imagen;//Incluye el modelo Imagen

class ImagenController extends Controller {
    


    public function destroy($id) {
    	$imagen = Imagen::find($id);
    	$id_producto = $imagen->id_producto;

        \Storage::disk('local')->delete($imagen->ruta);
        \Storage::disk('local')->delete("thumbs/".$imagen->ruta);
        
    	$imagen->delete();

    	return redirect()->route('producto.edit',$id_producto)->with('success','La imagen fue eliminada correctamente.');
    }

    public function marcarPrincipal($id){
    	$imagen = Imagen::find($id);
    	$imagen->es_principal = 1;

    	Imagen::where('id_producto', $imagen->id_producto)
          ->update(['es_principal' => 0]);

        $imagen->save();

        //return redirect()->route('producto.edit',$imagen->id_producto)->with('success','La imagen fue marcada principal correctamente.');
    	return array('success' => "La imagen fue marcada principal correctamente.");
    }

}
