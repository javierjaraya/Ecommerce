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

            if(Auth::check()){
                $id_usuario = Auth::id();
                $cliente = CLiente::idUsuario($id_usuario)->get();
                //Verificar si existe carro
                $carro_compra = CarroCompra::idCliente($cliente[0]->id)->get();
                //Si no hay un carro creado lo creamos
                if (count($carro_compra) == 0) {
                    $carro_compra = CarroCompra::create(
                        [
                            'id_cliente'=> $cliente[0]->id
                        ]
                    );
                }else{
                    $carro_compra = $carro_compra[0];
                }

                $cantidadTemp = DB::select(
                    'select sum(cantidad) as cantidad from detalle_carro_compra where id_carro_compra = ? GROUP BY id_carro_compra ', [$carro_compra->id_carro_compra]
                );
                $cantidad_total_carro = $cantidadTemp[0]->cantidad;

                $totalTemp = DB::select(
                    'select sum(precio*cantidad) as total from detalle_carro_compra where id_carro_compra = ? GROUP BY id_carro_compra ', [$carro_compra->id_carro_compra]
                );
                $total_carro = $totalTemp[0]->total;
            }else{
                $cantidad_total_carro = 0;
            }

            $view->with('categorias', $categorias)
                ->with('total_carro',$total_carro)
                ->with('cantidad_total_carro',$cantidad_total_carro);
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
