<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;//Para poder utilizar el Faker y generar datos

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

    	$faker = Faker::create();

    	//Creamos 2 perfiles
    	
	    DB::table('perfil')->insert(array(
	    		'idPerfil' => 1,
	           'nombrePerfil'  => 'Cliente'
	    ));
	    DB::table('perfil')->insert(array(
	    		'idPerfil' => 2,
	           'nombrePerfil'  => 'Administrador'
	    ));

        
		//EJEMPLOS
        //'nombre'  => $faker->randomElement(['chocolate','vainilla','cheesecake']),
		//'created_at' => date('Y-m-d H:m:s'),
		//'updated_at' => date('Y-m-d H:m:s')
        // 'password' => bcrypt('secret'),
        //str_random(10)  cadena de 10 caracteres aleatorios
    }
}
