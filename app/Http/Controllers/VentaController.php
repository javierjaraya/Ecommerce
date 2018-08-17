<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Cliente;
use App\CarroCompra;
use App\DetalleCarroCompra;
use App\Venta;
use App\EstadoVenta;
use App\DetalleVenta;
use App\Producto;
use Illuminate\Support\Facades\Auth;//Para acceder al auth
use Illuminate\Support\Facades\DB;
use Session;
//use Mail;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class VentaController extends Controller
{
    
    public function index($id_estado_venta){
        $ventas = Venta::IdEstadoVenta($id_estado_venta)->orderBy('created_at', 'desc')->paginate(7);
        $estadoVenta = EstadoVenta::find($id_estado_venta);

        return view('venta.index')
        	->with('ventas',$ventas)
        	->with('estadoVenta',$estadoVenta);
    }

    public function store(Request $request){

		//Validar que hay una session abierta
		if(Auth::check()){
			//Validar que el usuario tiene sus datos completados
            $id_usuario = Auth::id();
            $cliente = CLiente::idUsuario($id_usuario)->first();
            $carro_compra = CarroCompra::idCliente($cliente->id)->first();
            $detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();

            \Session::put('id_carro_compra', $carro_compra->id_carro_compra);


            //Comprobar que hay productos en el carro
            if(count($detalleCarro) > 0){
            	//Guardamos datos de la venta temporalemnte en la session
            	Session::put('id_tipo_despacho', $request->id_tipo_despacho);
            	Session::put('comentario_despacho', $request->comentario_despacho);
            	Session::put('rut_retira', $request->rut_retira);
            	Session::put('nombre_retira', $request->nombre_retira);
            	Session::put('apellido_retira', $request->apellido_retira);
            	Session::put('telefono_retira', $request->telefono_retira);
            	Session::put('direccion_retira', $request->direccion_retira);
            	Session::put('id_medio_pago', $request->id_medio_pago);

	            
	            //---------> Aqui debe realizarce el pago de la venta <--------
	            if($request->id_medio_pago == 1){
	            	//Pagar con webpay
	            }else if($request->id_medio_pago == 2){
	            	//Pagar con PayPal
	            	return redirect('payment');
	        	}else if($request->id_medio_pago == 3){
	        		//Pago por transferencia 
	        		return \Redirect::route('guardarVenta',[2]);//2 = pago pendiente
	        	}

	        }else{
	        	//Si no hay productos en el carro
	        	return redirect('carroCompra')->with('error','No hay prodcutos en el carrito.');
	        }
		}
		return view('auth.login');
	}

	public function guardarVenta($id_estado_venta){
		//Validar que hay una session abierta
		if(Auth::check()){
			$id_usuario = Auth::id();
            $cliente = CLiente::idUsuario($id_usuario)->first();
            $carro_compra = CarroCompra::idCliente($cliente->id)->first();
            $detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();


            $newVenta = Venta::create(
	    		[	
	    			'id_cliente' => $cliente->id,
	    			'id_tipo_despacho' => Session::get('id_tipo_despacho'),
	    			'comentario_despacho' => Session::get('comentario_despacho'),
	    			'rut_retira' => Session::get('rut_retira'),
	    			'nombre_retira' => Session::get('nombre_retira'),
	            	'apellido_retira' => Session::get('apellido_retira'),
	            	'telefono_retira' => Session::get('telefono_retira'),
	            	'direccion_retira' => Session::get('direccion_retira'),
	            	'id_medio_pago' => Session::get('id_medio_pago'),
	            	'id_estado_venta' => $id_estado_venta,
	    		]
    	    );

            $info = "";
    	    if($id_estado_venta == 2){
    	    	$info = "Pago pendiente....";
    	    }else{
    	    	$info = "Pago realizado correctamente";
    	    }

            foreach ($detalleCarro as $detalle) {
            	//Comprobar los stock de los productos
            	if($detalle->cantidad <= $detalle->producto->stock){
            		//Descontar stock
            		$detalle->producto->stock =  $detalle->producto->stock - $detalle->cantidad;
            		$detalle->producto->save();

            		//Registrar detalle a la venta
            		$newDetalleVenta = DetalleVenta::create(
            			[
            				'id_producto' => $detalle->id_producto,
            				'cantidad' => $detalle->cantidad,
            				'precio' => $detalle->precio,
            				'id_venta' => $newVenta->id_venta,
            			]
            		);

            		//Quitamos el producto del carro
            		$detalle->delete();
            	}
            }

            //Visualizar vista resumen venta (Con las etapas futuras señalando la actual)
	        return \Redirect::route('resumenVenta',[$newVenta->id_venta]);

		}
		return view('auth.login');
	}

	public function resumenVenta($id_venta){

		//Validar que hay una session abierta
		if(Auth::check()){
			//Validar que el usuario actual sea igual al usuario de la venta
			$id_usuario = Auth::id();
		    $cliente = CLiente::idUsuario($id_usuario)->first();

			$venta = Venta::find($id_venta);

			if($venta->id_cliente == $cliente->id){
				$detalleVenta = DetalleVenta::idVenta($id_venta)->get();

				$totalVenta = 0;

				$temp = DB::select('select sum(precio*cantidad) as total from detalle_venta where id_venta = ? ', 
					[$venta->id_venta]);

				$totalVenta = $temp[0]->total;

				return view('venta.resumenVenta')
				    ->with('venta',$venta)
				    ->with('detalleVenta',$detalleVenta)
				    ->with('totalVenta',$totalVenta);
			}
		}
		return redirect('/');
	}

	/*
	* Metodo que retorana una vista con un registro historico de las compras realizadas
	* por un cliente que tenga su session iniciada.
	*/
	public function misCompras(){
		$id_usuario = Auth::id();
        $cliente = CLiente::idUsuario($id_usuario)->first();

        $misCompras = Venta::idCliente($cliente->id)->orderBy('created_at', 'desc')->paginate(7);

        return view('venta.misCompras')
        	->with('mis_compras',$misCompras);
	}

	public function detalleVenta($id_venta){

		$venta = Venta::find($id_venta);
		$cliente = Cliente::find($venta->id_cliente);
		$detalleVenta = DetalleVenta::idVenta($id_venta)->get();

		$totalVenta = 0;

		$temp = DB::select('select sum(precio*cantidad) as total from detalle_venta where id_venta = ? ', 
			[$venta->id_venta]);

		$totalVenta = $temp[0]->total;

		return view('venta.detalleVenta')
		    ->with('venta',$venta)
		    ->with('detalleVenta',$detalleVenta)
		    ->with('totalVenta',$totalVenta)
		    ->with('cliente',$cliente);
	}

	public function confirmarPago($id_venta){
		$venta = Venta::find($id_venta);
		$venta->id_estado_venta = 3;
		$venta->save();

		$cliente = Cliente::find($venta->id_cliente);
		$usuario = Usuario::find($cliente->id_usuario);

		//Enviar correo informado que el pago se a validado
		$email = new \stdClass();
        $email->destinatario = $usuario->email;
        $email->asunto = 'Pago validado';
        $email->nombre_cliente = $cliente->nombres_razon_social;
        $email->id_estado_venta = $venta->id_estado_venta;
        $email->numero_orden = $venta->id_venta;
 
        Mail::to($usuario->email)->send(new Email($email));
		

		return \Redirect::route('detalleVenta',[$venta->id_venta])
			->with('success','Pago confirmado');
	}

	public function confirmarOrden($id_venta){
		$venta = Venta::find($id_venta);
		$venta->id_estado_venta = 4;
		$venta->save();

		return \Redirect::route('detalleVenta',[$venta->id_venta])
			->with('success','Orden confirmada');
	}

	public function listaParaRetirar($id_venta){
		$venta = Venta::find($id_venta);
		$venta->id_estado_venta = 5;
		$venta->save();

		return \Redirect::route('detalleVenta',[$venta->id_venta])
			->with('success','Orden lista para retirar');
	}

	public function compraEntregada($id_venta){
		$venta = Venta::find($id_venta);
		$venta->id_estado_venta = 6;
		$venta->save();

		$cliente = Cliente::find($venta->id_cliente);
		$usuario = Usuario::find($cliente->id_usuario);

		//Informar al cliente por email que la compra fue entregada
		$email = new \stdClass();
        $email->destinatario = $usuario->email;
        $email->asunto = 'Pedido Entregado';
        $email->nombre_cliente = $cliente->nombres_razon_social;
        $email->id_estado_venta = $venta->id_estado_venta;
        $email->numero_orden = $venta->id_venta;
 
        Mail::to($usuario->email)->send(new Email($email));

		return \Redirect::route('detalleVenta',[$venta->id_venta])
			->with('success','Compra entregada');
	}

	public function anularCompra($id_venta){
		$venta = Venta::find($id_venta);
		$venta->id_estado_venta = 1;
		$venta->save();

		//Liberar stock
		$detalleVenta = DetalleVenta::idVenta($id_venta)->get();

		foreach ($detalleVenta as $detalle) {
			$producto = Producto::find($detalle->id_producto);
			$producto->stock += $detalle->cantidad;
			$producto->save();
		}

		$cliente = Cliente::find($venta->id_cliente);
		$usuario = Usuario::find($cliente->id_usuario);

		//Informar al cliente por email que la compra fue anulada
		$email = new \stdClass();
        $email->destinatario = $usuario->email;
        $email->asunto = 'Compra anulada';
        $email->nombre_cliente = $cliente->nombres_razon_social;
        $email->id_estado_venta = $venta->id_estado_venta;
        $email->numero_orden = $venta->id_venta;
 
        Mail::to($usuario->email)->send(new Email($email));

		return \Redirect::route('detalleVenta',[$venta->id_venta])
			->with('success','Compra anulada');
	}
}
