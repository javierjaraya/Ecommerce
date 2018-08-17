<?php 
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\EstadoVenta;


// Inicio
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('home'));
});

//Ventas
Breadcrumbs::for('ventas', function ($trail, $estadoVenta) {
	$trail->parent('home');
    $trail->push($estadoVenta->estado_venta, route('ventas',[$estadoVenta->id_estado_venta]));
});

//Detalle venta
Breadcrumbs::for('detalleVenta', function ($trail,$venta) {
	$estadoVenta = EstadoVenta::find($venta->id_estado_venta);
	$trail->parent('ventas',$estadoVenta);
    $trail->push('Detalle Venta', route('detalleVenta',[$venta->id_venta]));
});

//Mis Compras
Breadcrumbs::for('misCompras', function ($trail) {
	$trail->parent('home');
    $trail->push('Mis Compras', route('misCompras'));
});


//Resumen venta
Breadcrumbs::for('resumenVenta', function ($trail,$venta) {
	$trail->parent('misCompras');
    $trail->push('Resumen Venta', route('resumenVenta',[$venta->id_venta]));
});

// Productos
Breadcrumbs::for('productos', function ($trail) {
	$trail->parent('home');
    $trail->push('Productos', route('producto.index'));
});

// Crear Producto
Breadcrumbs::for('createProducto', function ($trail) {
	$trail->parent('productos');
    $trail->push('Crear producto', route('producto.create'));
});
// Editar Producto
Breadcrumbs::for('editProductos', function ($trail,$id_producto) {
	$trail->parent('productos');
    $trail->push('Editar producto', route('producto.edit',[$id_producto]));
});
//Oferta Producto
Breadcrumbs::for('ofertas', function ($trail,$id_producto) {
	$trail->parent('productos');
    $trail->push('Ofertas', route('oferta.index',[$id_producto]));
});
//Crear Oferta Producto
Breadcrumbs::for('crearOferta', function ($trail,$id_producto) {
	$trail->parent('ofertas',$id_producto);
    $trail->push('Crear Oferta', route('oferta.create',[$id_producto]));
});
//Editar Oferta Producto
Breadcrumbs::for('editarOferta', function ($trail,$oferta) {
	$trail->parent('ofertas',$oferta->id_producto);
    $trail->push('Editar Oferta', route('oferta.edit',[$oferta->id]));
});

// Carro Compra
Breadcrumbs::for('carroCompra', function ($trail) {
	$trail->parent('home');
    $trail->push('Carro Compra', route('carroCompra'));
});

//Caja Compra
Breadcrumbs::for('cajaCompra', function ($trail) {
	$trail->parent('carroCompra');
    $trail->push('Caja', route('caja'));
});

//Iniciar sesion
Breadcrumbs::for('login', function ($trail) {
	$trail->parent('home');
    $trail->push('Iniciar sesion', route('login'));
});

//Registrarme
Breadcrumbs::for('register', function ($trail) {
	$trail->parent('home');
    $trail->push('Registrarme', route('register'));
});

//Mis datos
Breadcrumbs::for('misDatos', function ($trail) {
	$trail->parent('home');
    $trail->push('Mis datos', route('misdatos'));
});

//resultadoBusqueda
Breadcrumbs::for('resultadoBusqueda', function ($trail) {
	$trail->parent('home');
    $trail->push('Resultado busqueda', route('busqueda'));
});

