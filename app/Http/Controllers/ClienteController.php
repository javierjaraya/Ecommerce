<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//Para acceder al auth
use Illuminate\Support\Facades\DB;//Para acceder a la BD
use App\Http\Requests\ClienteRequest;//Para la validacion
use App\Cliente;
use App\Region;//Incluye el modelo Region
use App\Provincia;//Incluye el modelo Provincia
use App\Comuna;//Incluye el modelo Comuna

class ClienteController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function findLogin() {
    	$user = Auth::user();//Obtenemos el usuario auth
    	$id = Auth::id();

    	$objet = DB::table('cliente')->select('id', 'rut','nombres_razon_social', 'apellidos','giro','direccion','id_comuna','contacto','id_usuario')->where('id_usuario','=',$id)->get();    

    	//$regiones = Region::all();
    	//$provincias = Provincia::all();
    	$comunas = Comuna::all();

        return view('cliente.misDatos')->with('cliente', $objet[0])->with('comunas',$comunas);
    }

    /**
     * 
     */
    public function update (ClienteRequest $request, $id){
    	$cliente = Cliente::find($id);
		$cliente->update($request->all());
    	return redirect()->route('misdatos')->with('success','Datos actualizado correctamente');
    }
}
