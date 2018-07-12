<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Permisos usuario administrador
 */
Route::group(['middleware' => 'admin'], function () {

});

/**
* Permisos usuario registrado
*/
Route::group(['middleware' => 'user'], function () {
	Route::get('/misdatos', 'ClienteController@findLogin')->name('misdatos');	
});

//Route::get('/misdatos', 'ClienteController@findLogin')->name('misdatos')->middleware('user');
/**
 *  Rutas AJAX
 */
/* Obtener subcategorias por idcategoria */
Route::get('/subcategorias/{id_categoria?}','SubCategoriaController@listadoByCategoria');

/**
 * TEST
 */
Route::get('/test',function(){
	return view('prueba');
});

/*
|-------------------------------------------------------------------------
| Rutas Contenedor Cliente
|-------------------------------------------------------------------------
| cliente.index 	GET|HEAD 	Muestra listado de clientes
| cliente.store  	POST 		Guardar cliente
| cliente.create 	GET|HEAD 	Muestra formulario crear un cliente
| cliente.show   	GET|HEAD 	Muestra un cliente
| cliente.update 	PUT|PATCH 	Guarda cambios editar
| cliente.destroy 	DELETE 		Elimina un cliente
| cliente.edit   	GET|HEAD 	Muestra formulario editar cliente
*/
Route::resource('cliente', 'ClienteController')->middleware('user');

/*
|-------------------------------------------------------------------------
| Rutas Contenedor Producto
|-------------------------------------------------------------------------
| producto.index 	GET|HEAD 	Muestra listado de productos
| producto.store  	POST 		Guardar producto
| producto.create 	GET|HEAD 	Muestra formulario crear un producto
| producto.show   	GET|HEAD 	Muestra un producto
| producto.update 	PUT|PATCH 	Guarda cambios editar
| producto.destroy 	DELETE 		Elimina un producto
| producto.edit   	GET|HEAD 	Muestra formulario editar producto
*/
Route::resource('producto', 'ProductoController')->middleware('admin');
Route::GET('producto.search','ProductoController@search')->middleware('admin')->name('searchProduct');
Route::GET('producto.removemodal','ProductoController@removeModal')->middleware('admin')->name('productoRemoveModal');

/*
|-------------------------------------------------------------------------
| Rutas Contenedor Imagen
|-------------------------------------------------------------------------
| imagen.index 	GET|HEAD 	Muestra listado de imagenes
| imagen.store  	POST 		Guardar imagen
| imagen.create 	GET|HEAD 	Muestra formulario crear imagen
| imagen.show   	GET|HEAD 	Muestra un imagen
| imagen.update 	PUT|PATCH 	Guarda cambios editar
| imagen.destroy 	DELETE 		Elimina un imagen
| imagen.edit   	GET|HEAD 	Muestra formulario editar imagen
*/
Route::resource('imagen', 'ImagenController')->middleware('admin');
Route::get('marcarPrincipal/{id}','ImagenController@marcarPrincipal')->middleware('admin')->name('marcarPrincipal');
/*
|-------------------------------------------------------------------------
| Rutas Contenedor Especificacion
|-------------------------------------------------------------------------
| especificacion.index 		GET|HEAD 	Muestra listado de especificaciones
| especificacion.store  	POST 		Guardar especificacion
| especificacion.create 	GET|HEAD 	Muestra formulario crear un especificacion
| especificacion.show   	GET|HEAD 	Muestra un especificacion
| especificacion.update 	PUT|PATCH 	Guarda cambios editar
| especificacion.destroy 	DELETE 		Elimina un especificacion
| especificacion.edit   	GET|HEAD 	Muestra formulario editar especificacion
*/
Route::resource('especificacion', 'EspecificacionController')->middleware('admin');
Route::GET('especificacion.editmodal','EspecificacionController@editModal')->middleware('admin')->name('especificacionEditModal');
Route::GET('especificacion.removemodal','EspecificacionController@removeModal')->middleware('admin')->name('especificacionRemoveModal');

/*
|-------------------------------------------------------------------------
| Rutas Contenedor Oferta
|-------------------------------------------------------------------------
| Oferta.index 		GET|HEAD 	Muestra listado de ofertas
| Oferta.store  	POST 		Guardar oferta
| Oferta.create 	GET|HEAD 	Muestra formulario crear una oferta
| Oferta.show   	GET|HEAD 	Muestra una oferta
| Oferta.update 	PUT|PATCH 	Guarda cambios editar
| Oferta.destroy 	DELETE 		Elimina una oferta
| Oferta.edit   	GET|HEAD 	Muestra formulario editar oferta
*/
Route::resource('oferta','OfertaController')->middleware('admin');
Route::get('ofertas/{id}','OfertaController@index')->middleware('admin');
Route::GET('oferta.removemodal','OfertaController@removeModal')->middleware('admin')->name('ofertaRemoveModal');


