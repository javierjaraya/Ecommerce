<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OfertaRequest;//Para la validacion
use App\Oferta;//Incluye el modelo Oferta
use App\Producto;//Incluye el modelo Producto

class OfertaController extends Controller
{
    public function index($id_producto){

    	$producto = Producto::find($id_producto);
    	$ofertas = Oferta::IdProducto($id_producto)->orderByRaw('id_producto DESC')->paginate(10);

    	return view('oferta.index')->with('idProducto',$id_producto)->with('ofertas',$ofertas)->with('producto',$producto);
    }

    public function create($id_producto){
    	$producto = Producto::find($id_producto);
    	return view('oferta.create')->with('producto',$producto);
    }

    public function store(OfertaRequest $request){

    	$newOferta = Oferta::create($request->all());

        return redirect('ofertas/'.$newOferta->id_producto)->with('success','Oferta creada correctamente.');
    }

    public function edit($id){
    	$oferta = Oferta::find($id);
    	$producto = Producto::find($oferta->id_producto);
    	return view('oferta.edit')->with('oferta',$oferta)->with('producto',$producto);
    }

    public function update(OfertaRequest $request, $id){
    	$oferta = Oferta::find($id);

    	$oferta->update($request->all());

        return redirect('ofertas/'.$oferta->id_producto)->with('success','Oferta actualizada correctamente.');
    }

    public function removeModal(Request $request){
    	$oferta = Oferta::find($request->id);

        $oferta->delete();
        
        return redirect('ofertas/'.$oferta->id_producto)->with('success','Oferta eliminada correctamente.');
    }
}
