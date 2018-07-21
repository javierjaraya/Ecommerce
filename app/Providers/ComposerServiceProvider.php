<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
            $view->with('categorias', $categorias);
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
