<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\CarroCompra;
use App\DetalleCarroCompra;

class CarroCompraController extends Controller
{
	

	public function show($id){

    	$cliente = CLiente::idUsuario($id)->get();		

		$carro_compra = CarroCompra::idCliente($cliente[0]->id)->get();

    	if (count($carro_compra) == 0) {
    		$carro_compra = CarroCompra::create(
    			[
    				'id_cliente'=> $cliente[0]->id
    			]
    		);
    	}else{
    		$carro_compra = $carro_compra[0];
    	}

    	$detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();

		return view('carrocompra.show')
			->with('carro_compra',$carro_compra)
			->with('detalle_carro',$detalleCarro);
	}   	
}
