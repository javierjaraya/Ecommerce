<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\CarroCompra;
use App\DetalleCarroCompra;
use Illuminate\Support\Facades\Auth;//Para acceder al auth
use Illuminate\Support\Facades\DB;
use Cookie;

class CarroCompraController extends Controller {
	
	public function show(Request $request){

		if(Auth::check()){
			//Si hay session obtiene los datos de la BD
			//Si hay Cookies Sincronizar
			$id_usuario = Auth::id();
	    	$cliente = CLiente::idUsuario($id_usuario)->first();		

			$carro_compra = CarroCompra::idCliente($cliente->id)->first();

	    	$detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();

			return view('carrocompra.show')
				->with('carro_compra',$carro_compra)
				->with('detalle_carro',$detalleCarro);
		}else{
			$control = new CarroCompraController();
			return $control->carroCookies($request);
		}
	}   	

	public function caja(){
		//Validar que hay una session abierta
		if(Auth::check()){
			//Validar que el usuario tiene sus datos completados
            $id_usuario = Auth::id();
            $cliente = CLiente::idUsuario($id_usuario)->first();

            if($cliente->rut){
            	$carro_compra = CarroCompra::idCliente($cliente->id)->first();
            	$detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();
            	return view('carrocompra.caja')
            		->with('cliente',$cliente)	
            		->with('carro_compra',$carro_compra)
            		->with('detalle_carro',$detalleCarro);	
            }else{
            	return redirect()->route('misdatos')->with('warning','Debe completar sus datos personales para continuar.');
            }

        }else{
        	return view('auth.login');
        }
	}

	public function pagar(Request $request){
		return 'pagado';
	}

	public function carroCookies(Request $request){

		$detalleCarroCookies = \Cookie::get('detalleCarroCookies');
        
        $listaDetallesCookies = json_decode($detalleCarroCookies);
        $listaDetalles = array();

        if(is_array($listaDetallesCookies)){
        	foreach ($listaDetallesCookies as $key => $detalleCookie) {
                $detalle = new DetalleCarroCompra;
                $detalle->id_producto = $detalleCookie->id_producto;
                $detalle->cantidad = $detalleCookie->cantidad;
                $detalle->precio = $detalleCookie->precio;

                $listaDetalles[] = $detalle;
                
            }
        }

		return view('carrocompra.show')
			->with('detalle_carro',$listaDetalles);
	}

	public function totalCarroCookies(){
		$detalleCarroCookies = \Cookie::get('detalleCarroCookies');
        
        $listaDetallesCookies = json_decode($detalleCarroCookies);
        $totalCarro = 0;
        $cantidadCarro = 0;

        if(is_array($listaDetallesCookies)){
        	foreach ($listaDetallesCookies as $key => $detalleCookie) {
                $totalCarro += $detalleCookie->precio*$detalleCookie->cantidad;
                $cantidadCarro += $detalleCookie->cantidad;
            }
        }

        return array(
        	'cantidad' => $cantidadCarro, 
        	'total' => $totalCarro,
    	);

	}

	public function sincronizarCarroCookies(){
		$detalleCarroCookies = Cookie::get('detalleCarroCookies');
		$listaDetallesCookies = json_decode($detalleCarroCookies);

		//si hay usuario logeado
		if(Auth::check()){
			//si hay un listado en cookies
			if(is_array($listaDetallesCookies)){
				//Obtener el usuario logeado
				$id_usuario = Auth::id();
            	$cliente = CLiente::idUsuario($id_usuario)->first();

				//Obtener detalle carro desde BD
            	$carro_compra = CarroCompra::idCliente($cliente->id)->first();
            	$detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();

				//comparar cada elemento de la lista con el detalle de la BD
				foreach ($listaDetallesCookies as $key => $detalleCookie) {
					$esta = false;

					foreach ($detalleCarro as $detalle) {
						if($detalle->id_producto == $detalleCookie->id_producto){
							//Si esta un elemento sumarlo
							$detalle->cantidad += $detalleCookie->cantidad;
			    			DB::update('update detalle_carro_compra set cantidad = ? where id_detalle_carro = ?', 
			    				[$detalle->cantidad, $detalle->id_detalle_carro]
			    			);
							$esta = true;
						}
					}
					if(!$esta){
						//Si no esta se agrega
						$newDetalle = DetalleCarroCompra::create(
		    	    		[	
		    	    			'precio' => $detalleCookie->precio,
		    	    			'cantidad' => $detalleCookie->cantidad,
		    	            	'id_producto' => $detalleCookie->id_producto,
		    	            	'id_carro_compra' => $carro_compra->id_carro_compra,
		    	    		]
		    	    	);
					}
					//Eliminar elemento del array cookies
					unset($listaDetallesCookies[$key]);
              	
            	}
            	//vaciar lista cookies
				setcookie('detalleCarroCookies',json_encode($listaDetallesCookies));
            	return true;
			}
		}//endif Auth

		return false;
	}
}
