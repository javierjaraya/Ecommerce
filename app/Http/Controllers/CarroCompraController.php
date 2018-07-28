<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\CarroCompra;
use App\DetalleCarroCompra;
use Illuminate\Support\Facades\Auth;//Para acceder al auth

class CarroCompraController extends Controller
{
	
    public function __construct(){

    }

	public function show($id){

    	$cliente = CLiente::idUsuario($id)->get();		

		$carro_compra = CarroCompra::idCliente($cliente[0]->id)->first();

    	$detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();

		return view('carrocompra.show')
			->with('carro_compra',$carro_compra)
			->with('detalle_carro',$detalleCarro);
	}   	

	public function caja(){
		if(Auth::check()){
            //$id_usuario = Auth::id();
            //$cliente = CLiente::idUsuario($id_usuario)->get();
			return view('carrocompra.caja');
        }else{
        	return view('login');
        }
	}
}
