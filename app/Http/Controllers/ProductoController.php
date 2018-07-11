<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;//Para la validacion
use App\Http\Requests\ProductoUpdateRequest;//Para la validacion
use App\Producto;//Incluye el modelo Producto
use App\Categoria;//Incluye el modelo Categoria
use App\SubCategoria;//Incluye el modelo SubCategoria
use App\Imagen;//Incluye el modelo Imagen
use App\Especificacion;//Incluye el modelo Especificacion
use Illuminate\Support\Facades\DB;//para acceder a la bd

class ProductoController extends Controller {
    
    public function index(){
        $productos = Producto::paginate(10);
        $search = "";
        return view('producto.index')->with('productos',$productos)->with('search', $search);     	
    }

    public function search(Request $request){
        $search = $request->search;

        $productos = Producto::id($search)->paginate(10);
        return view('producto.index',compact('productos'))->with('search',$search);    
    }

    public function create(){
    	$categorias = Categoria::all();

    	return view('producto.create')->with('categorias',$categorias);
    }

    public function store(ProductoRequest $productoRequest){
    	
    	$newProducto = Producto::create($productoRequest->all());

    	//obtenemos el campo file definido en el formulario
    	$files = $productoRequest->file('imagenes');
    	
        $i = 0;
		if($productoRequest->hasFile('imagenes')) {
			//recorremos el array de imagenes para subirlas al simultaneo
		    foreach ($files as $file) {
		        
			//obtenemos el nombre del archivo
       		$nombre = $file->getClientOriginalName();
       		$foo = \File::extension($nombre);
       		$now = new \DateTime();
			$fecha = $now->format('Y-m-d-H-i-s');

			$newNombre = $fecha.".".strtolower($foo);

       		//indicamos que queremos guardar un nuevo archivo en el disco local
	        \Storage::disk('local')->put($newNombre, \File::get($file));
	        
	        $imagen = new Imagen;
			$imagen->ruta = $newNombre;
            if($i == 0){
                $imagen->es_principal = 1;    
            }else{
                $imagen->es_principal = 0;   
            }
            $i++;
			
			$imagen->id_producto = $newProducto->id;
			$imagen->save();  

		    }
		}
    	
    	return redirect()->route('producto.index')->with('success','Producto creado correctamente.');
    }

    public function edit($id){
        $producto = Producto::find($id);

        //SubCategoria del producto
        $subCategoria = DB::table('subcategoria')->where('id',$producto->id_subcategoria )->first();

        $categorias = Categoria::all();

        //Obtener subcategorias de la misma categoria
        $subCategorias = SubCategoria::where('id_categoria', '=', $subCategoria->id_categoria)->get();

        //Obtiene todas las especificaciones del producto
        $especificaciones = Especificacion::where('id_producto', '=', $id)->get();
        

        return view('producto.edit')
        ->with('producto',$producto)
        ->with('categorias',$categorias)
        ->with('subCategorias',$subCategorias)
        ->with('especificaciones', $especificaciones)
        ->with('id_categoria',$subCategoria->id_categoria);
    }

    public function update(ProductoUpdateRequest $productoUpdateRequest,$id){        

        $producto = Producto::find($id);
        $producto->update($productoUpdateRequest->all());

        //obtenemos el campo file definido en el formulario
        $files = $productoUpdateRequest->file('imagenes');
        

        if($productoUpdateRequest->hasFile('imagenes')) {
            $i = 1;
            //recorremos el array de imagenes para subirlas al simultaneo
            foreach ($files as $file) {
            set_time_limit (30);
            //obtenemos el nombre del archivo
            $nombre = $file->getClientOriginalName();
            $foo = \File::extension($nombre);
            $now = new \DateTime();
            $fecha = $now->format('YmdHis');

            $newNombre = $fecha."_".$i."_product.".strtolower($foo);

            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('local')->put($newNombre, \File::get($file));
            
            $imagen = new Imagen;
            $imagen->ruta = $newNombre;
            $imagen->es_principal = 0;
            $imagen->id_producto = $producto->id;
            $imagen->save();  
            $i++;
            }
        }
        
        return redirect()->route('producto.edit',$id)->with('success','Producto actualizado correctamente.');
    }

    public function removeModal(Request $requeest){
        $producto = Producto::find($requeest->id);

        $imagenes = Imagen::where('id_producto', '=', $requeest->id)->get();

        foreach ($imagenes as $imagen) {
            \Storage::disk('local')->delete($imagen->ruta);
        }

        DB::table('especificacion')->where('id_producto', '=', $requeest->id)->delete();
        DB::table('imagen')->where('id_producto', '=', $requeest->id)->delete();

        $producto->delete();
        return array(
            'success' => 'Producto eliminada correctamente', 
        );
    }
}
