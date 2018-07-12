<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OfertaRequest;//Para la validacion
use App\Oferta;//Incluye el modelo Oferta
use App\Producto;//Incluye el modelo Producto

class OfertaController extends Controller
{
    public function index(Request $request){

    	$producto = Producto::find($request->idProducto);
    	$ofertas = Oferta::IdProducto($request->idProducto)->orderByRaw('id_producto DESC')->paginate(10);

    	return view('oferta.index')->with('idProducto',$request->idProducto)->with('ofertas',$ofertas)->with('producto',$producto);
    }

    public function create(Request $request){
    	$producto = Producto::find($request->idProducto);
    	return view('oferta.create')->with('idProducto',$request->idProducto)->with('producto',$producto);
    }

    public function store(OfertaRequest $request){

    	$newOferta = Oferta::create($request->all());

    	$producto = Producto::find($newOferta->id_producto);  
    	$ofertas = Oferta::IdProducto($newOferta->id_producto)->orderByRaw('id_producto DESC')->paginate(10);

    	return view('oferta.index')->with('idProducto',$newOferta->id_producto)->with('ofertas',$ofertas)->with('producto',$producto)->with('success','Oferta creada correctamente.');
    }

    public function edit($id){
    	$oferta = Oferta::find($id);
    	$producto = Producto::find($oferta->id_producto);
    	return view('oferta.edit')->with('oferta',$oferta)->with('producto',$producto);
    }

    public function update(OfertaRequest $request, $id){
    	$oferta = Oferta::find($id);
    	$oferta->update($request->all());
    	
    	
    	$producto = Producto::find($oferta->id_producto);  
    	$ofertas = Oferta::IdProducto($oferta->id_producto)->orderByRaw('id_producto DESC')->paginate(10);

    	return view('oferta.index')->with('idProducto',$oferta->id_producto)->with('ofertas',$ofertas)->with('producto',$producto)->with('success','Oferta actualizada correctamente.');
    }

    public function removeModal(Request $request){
    	$oferta = Oferta::find($request->id);

        $oferta->delete();

        return array(
            'success' => 'Oferta eliminada correctamente', 
        );
    }
}
