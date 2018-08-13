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

Route::get('/', 'ProductoController@productosOferta');

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
Route::get('/email',function(){
	return view('mails.email_pedido_entregado');
});

/*
* Busqueda
*/
Route::get('/busqueda','ProductoController@buscardor')->name('busqueda');
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
Route::resource('producto', 'ProductoController');
Route::GET('producto/search','ProductoController@search')->middleware('admin')->name('searchProduct');
Route::GET('producto/removemodal','ProductoController@removeModal')->middleware('admin')->name('productoRemoveModal');
Route::get('producto/subcategoria/{id}','ProductoController@productoSubCategoria')->name('productoSubCategoria');

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
Route::GET('especificacion/editmodal','EspecificacionController@editModal')->middleware('admin')->name('especificacionEditModal');
Route::GET('especificacion/removemodal','EspecificacionController@removeModal')->middleware('admin')->name('especificacionRemoveModal');

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
Route::GET('oferta/removemodal','OfertaController@removeModal')->middleware('admin')->name('ofertaRemoveModal');

/*
|------------------------------------------------------------------------
| Rutas Contenedor Carro Compra
|------------------------------------------------------------------------
| 
|
*/
Route::get('carroCompra','CarroCompraController@show')->name('carroCompra');
Route::post('detalleCarro/store','DetalleCarroCompraController@store')->name('detalleCarroStore');
Route::put('detalleCarro/update/{id_detalle_carro}','DetalleCarroCompraController@update')->name('detalleCarroUpdate');
Route::delete('detalleCarro/destroy/{id_detalle_carro}','DetalleCarroCompraController@destroy')->name('detalleCarroDestroy');
Route::get('caja','CarroCompraController@caja')->name('caja');

/*
|------------------------------------------------------------------------
| Rutas Contenedor Venta
|------------------------------------------------------------------------
| 
|
*/
Route::post('pagar','VentaController@store')->name('pagar');
Route::get('resumenVenta/{id_venta}','VentaController@resumenVenta')->name('resumenVenta');
Route::get('guardarVenta/{id_estado_venta}','VentaController@guardarVenta')->name('guardarVenta');
Route::get('venta/misCompras','VentaController@misCompras')->name('misCompras')->middleware('user');
Route::get('ventas','VentaController@index')->name('ventas')->middleware('admin');
Route::get('detalleVenta/{id_venta}','VentaController@detalleVenta')->name('detalleVenta')->middleware('admin');

Route::get('confirmarPago/{id_venta}','VentaController@confirmarPago')->name('confirmarPago')->middleware('admin');
Route::get('confirmarOrden/{id_venta}','VentaController@confirmarOrden')->name('confirmarOrden')->middleware('admin');
Route::get('listaParaRetirar/{id_venta}','VentaController@listaParaRetirar')->name('listaParaRetirar')->middleware('admin');
Route::get('compraEntregada/{id_venta}','VentaController@compraEntregada')->name('compraEntregada')->middleware('admin');
Route::get('anularCompra/{id_venta}','VentaController@anularCompra')->name('anularCompra')->middleware('admin');
/*
|------------------------------------------------------------------------
| Rutas Contenedor PayPal
|------------------------------------------------------------------------
| 
*/
Route::get('payment', array(
	'as' => 'payment',
	'uses' => 'PaypalController@postPayment',
));

Route::get('payment/status', array(
	'as' => 'payment.status',
	'uses' => 'PaypalController@getPaymentStatus',
));
