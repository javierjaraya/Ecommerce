<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Para validar que una fecha sea mayor que otra*/
        Validator::extend('mayor_que_el_campo', function($attribute, $value, $parameters, $validator) {
          $min_field = $parameters[0];
          $data = $validator->getData();
          $min_value = $data[$min_field];
          return $value > $min_value;
        });   

        Validator::replacer('mayor_que_el_campo', function($message, $attribute, $rule, $parameters) {
          return str_replace(':field', $parameters[0], $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
