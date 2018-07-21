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
use Image;//Para redimensionar las imagenes a subir

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
			$fecha = $now->format('YmdHis');

            $newNombre = $fecha."_".$i."_product.".strtolower($foo);

            //$img = Image::make($file);
            //$img->resize(240, 240);
            //$ima->save(public_path('storage/thumbs/',$newNombre));
            //imagejpeg($file, public_path('storage/thumbs/',$newNombre),90);
            $image_info = imagecreatefromjpeg($file);
            $ancho = imagesx($image_info);
            $alto = imagesy($image_info);

            $thumb = imagecreatetruecolor(65,65);
            imagecopyresampled($thumb,$image_info,0,0,0,0,65,65,$ancho,$alto);
            imagejpeg($thumb,"storage/thumbs/".$newNombre,90);

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

            //Image::make($file)
            //->resize(100,100)
            //->save('storage/thumbs/',$newNombre);
            $image_info = imagecreatefromjpeg($file);
            $ancho = imagesx($image_info);
            $alto = imagesy($image_info);

            $thumb = imagecreatetruecolor(65,65);
            imagecopyresampled($thumb,$image_info,0,0,0,0,65,65,$ancho,$alto);
            imagejpeg($thumb,"storage/thumbs/".$newNombre,90);

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
        DB::table('oferta')->where('id_producto', '=', $requeest->id)->delete();

        $producto->delete();
        return array(
            'success' => 'Producto eliminada correctamente', 
        );
    }

    public function show($id){
        $producto = Producto::find($id);
        $oferta = DB::table('oferta')->where('id_producto',$id )->first();
        $especificaciones = DB::table('especificacion')->where('id_producto',$id )->get();

        return view('producto.show')
        ->with('producto',$producto)
        ->with('oferta',$oferta)
        ->with('especificaciones',$especificaciones);
    }

    public function productosOferta(){
        $productos = DB::table('producto')
            ->join('oferta','producto.id','=','oferta.id_producto')
            ->join('imagen','producto.id','=','imagen.id_producto')
            ->where('imagen.es_principal','=','1')
            ->get();

        return view('welcome')
        ->with('productos',$productos);
    }
}
