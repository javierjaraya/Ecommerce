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

class DetalleCarroCompraController extends Controller {

    public function store(DetalleCarroRequest $request){

        if(Auth::check()){
            //Si hay una sesion iniciada guarda en BD
            //Falta sincronozar cookies con BD si hay dantos en cookies************

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

            }else{
                //Si no hay una session utilizar un carro en las cookies
                $control = new DetalleCarroCompraController();
                return $control->registrarEnCookies($request);
            }

    }

    public function update(Request $request, $id_detalle_carro){

        if(Auth::check()){
            //Si hay una session actualiza en BD
            //Falta sincronizar cookies con BD si hay datos en cookies ********
        	$detalle = DetalleCarroCompra::find($id_detalle_carro);

        	if($request->cantidad == 0)
        		$detalle->delete();
        	else
        		$detalle->update($request->all());
        	

        	return redirect()->back()
        	    ->with('success','Carrito actualizado.')
        	    ->with('detalle',$detalle);
        }else{
            //Si no hay una session actualiza en cookies
            $control = new DetalleCarroCompraController();
            return $control->actualizarEnCookies($request);
        }
    }

    public function destroy(Request $request,$id_detalle_carro){
        if(Auth::check()){
        	$detalle = DetalleCarroCompra::findOrFail($id_detalle_carro);
        	$detalle->delete();

        	return redirect()->back()
        	    ->with('success','Carrito actualizado.')
        	    ->with('detalle',$detalle);
        }else{
            $control = new DetalleCarroCompraController();
            return $control->eliminarEnCookies($request);
        }
    }

    public function registrarEnCookies(DetalleCarroRequest $request){

        $detalleCarroCookies = \Cookie::get('detalleCarroCookies');
        
        $listaDetalles = json_decode($detalleCarroCookies);

        $esta = false;
        if(is_array($listaDetalles)){
            foreach ($listaDetalles as $key => $detalle) {
                if($detalle->id_producto == $request->id_producto){
                    //Si esta en la lista le aumenta la cantidad
                    $esta = true;

                    $producto = Producto::find($request->id_producto);
                    
                    $precio = $producto->precio_normal;
                    if(isset($request->precio_oferta)){
                        $precio = $request->precio_oferta;
                    }


                    $listaDetalles[$key] = array(
                        'id_producto' => $request->id_producto, 
                        'cantidad' => $request->cantidad+$detalle->cantidad,
                        'precio' => $precio
                    );
                }
            }
        }

        if(!$esta){
            //Si no esta en la lista lo agrega
            if($request->cantidad > 0){
                $producto = Producto::find($request->id_producto);
                    
                $precio = $producto->precio_normal;
                if(isset($request->precio_oferta)){
                    $precio = $request->precio_oferta;
                }

                $listaDetalles[] = array(
                    'id_producto' => $request->id_producto, 
                    'cantidad' => $request->cantidad,
                    'precio' => $precio
                );
            }
        }

        $json = json_encode($listaDetalles);

        return redirect()->back()
                ->with('success','Producto agregado al carrito.')
                ->cookie('detalleCarroCookies', $json, 1440);//1 Dia
    }

    public function actualizarEnCookies(Request $request){
        $detalleCarroCookies = \Cookie::get('detalleCarroCookies');
        
        $listaDetalles = json_decode($detalleCarroCookies);

        if(is_array($listaDetalles)){
            foreach ($listaDetalles as $key => $detalle) {
                if($detalle->id_producto == $request->id_producto){
                    //Si esta en la lista actualiza la cantidad
                    if($request->cantidad > 0){
                        $listaDetalles[$key] = array(
                            'id_producto' => $request->id_producto, 
                            'cantidad' => $request->cantidad,
                            'precio' => $detalle->precio
                        );
                    }else{
                        unset($listaDetalles[$key]);
                    }
                }
            }
        }

        $json = json_encode($listaDetalles);

        return redirect()->back()
                ->with('success','Carrito actualizado.')
                ->cookie('detalleCarroCookies', $json, 1440);//1 Dia
    }

    public function eliminarEnCookies(Request $request){
        $detalleCarroCookies = \Cookie::get('detalleCarroCookies');
        
        $listaDetalles = json_decode($detalleCarroCookies);

        if(is_array($listaDetalles)){
            foreach ($listaDetalles as $key => $detalle) {
                if($detalle->id_producto == $request->id_producto){
                    //Si esta en la lista se elimina
                    unset($listaDetalles[$key]);
                }
            }
        }

        $json = json_encode($listaDetalles);

        return redirect()->back()
            ->with('success','Carrito actualizado.')
            ->cookie('detalleCarroCookies', $json, 1440);//1 Dia

    }
}
