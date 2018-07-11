<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategoria;//Incluye el modelo SubCategoria

class SubCategoriaController extends Controller {
    
    public function listadoByCategoria($idCategoria){
    	$subcategorias = SubCategoria::where('id_categoria',$idCategoria)->get();
    	return $subcategorias;
    }
}
