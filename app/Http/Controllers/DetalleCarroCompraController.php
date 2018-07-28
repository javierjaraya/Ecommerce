<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DetalleCarroRequest;
use Illuminate\Support\Facades\DB;
use App\DetalleCarroCompra;
use App\Cliente;
use App\CarroCompra;
use App\Producto;
use App\Oferta;
use Illuminate\Support\Facades\Auth;//Para acceder al auth

class DetalleCarroCompraController extends Controller
{


    public function store(DetalleCarroRequest $request){

    	//Si no hay session iniciada guardar en cookie

    	//Obtener cliente actual
    	$id_usuario = Auth::id();
    	$cliente = CLiente::idUsuario($id_usuario)->first();	
    	$producto = Producto::find($request->id_producto);

    	$carro_compra = CarroCompra::idCliente($cliente->id)->first();
    	
    	//Si hay oferta utiliza el precio oferta
    	$precio = $producto->precio_normal;
    	if(isset($request->precio_oferta)){
    		$precio = $request->precio_oferta;
    	}

    	//Verificar si el producto ya esta agregado, si es asi sumar cantidad
    	//Obtener el detalle del carro para el producto si existe
    	$detalleTemp = DB::select(
    		'select * from detalle_carro_compra where id_producto = ? and id_carro_compra = ?', 
    		[$producto->id,$carro_compra->id_carro_compra]
    	);

    	if($detalleTemp != null){
			$detalleTemp[0]->cantidad += $request->cantidad;
			DB::update('update detalle_carro_compra set cantidad = ? where id_producto = ? and id_carro_compra = ?', 
				[$detalleTemp[0]->cantidad,$producto->id,$carro_compra->id_carro_compra]
			);
    	}else{
	    	$detalleTemp = DetalleCarroCompra::create(
	    		[	
	    			'precio' => $precio,
	    			'cantidad' => $request->cantidad,
	            	'id_producto' => $request->id_producto,
	            	'id_carro_compra' => $carro_compra->id_carro_compra,
	    		]
	    	);
    	}

    	return redirect()->back()
    	    ->with('success','Producto agregado al carrito.')
    	    ->with('detalle',$detalleTemp);

    }

    public function update(Request $request, $id_detalle_carro){
    	$detalle = DetalleCarroCompra::find($id_detalle_carro);

    	if($request->cantidad == 0)
    		$detalle->delete();
    	else
    		$detalle->update($request->all());
    	

    	return redirect()->back()
    	    ->with('success','Carrito actualizado.')
    	    ->with('detalle',$detalle);
    }

    public function destroy($id_detalle_carro){
    	$detalle = DetalleCarroCompra::findOrFail($id_detalle_carro);
    	$detalle->delete();

    	return redirect()->back()
    	    ->with('success','Carrito actualizado.')
    	    ->with('detalle',$detalle);
    }
}
