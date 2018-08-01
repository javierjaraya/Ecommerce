<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;//Para acceder al auth
use App\DetalleCarroCompra;
use App\Cliente;
use App\CarroCompra;
use App\Categoria;
use App\Http\Controllers\CarroCompraController;
use Cookie;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.app'], function($view) {
            $categorias = Categoria::all();
            //Obtener informacion del carro compra del usuario y enviarla a la vista
            $total_carro = 0;
            $cantidad_total_carro = 0;
            $cliente = null;

            $control = new CarroCompraController;

            if(Auth::check()){
                //Sincroniza el carro de compra de cookies a BD al iniciar la session
                $resultSincronizacion = $control->sincronizarCarroCookies();
                
                $id_usuario = Auth::id();
                $cliente = CLiente::idUsuario($id_usuario)->first();
                
                $carro_compra = CarroCompra::idCliente($cliente->id)->first();
                
                $carroTemp = DB::select(
                    'select sum(cantidad) as cantidad, sum(precio*cantidad) as total from detalle_carro_compra where id_carro_compra = ? GROUP BY id_carro_compra ', [$carro_compra->id_carro_compra]
                );
                if($carroTemp != null){
                    $cantidad_total_carro = $carroTemp[0]->cantidad;
                    $total_carro = $carroTemp[0]->total;
                }else{
                    $cantidad_total_carro = 0;
                    $total_carro = 0;
                }

            }else{
                $totalCookies =  $control->totalCarroCookies();
                $cantidad_total_carro = $totalCookies['cantidad'];
                $total_carro = $totalCookies['total'];
            }

            $view->with('categorias', $categorias)
                ->with('total_carro',$total_carro)
                ->with('cantidad_total_carro',$cantidad_total_carro)
                ->with('cliente',$cliente);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
