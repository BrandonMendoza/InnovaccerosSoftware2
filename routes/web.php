<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {

	//TIPOS_MATERIALES
	Route::get('/materialesTipos/show','materialesTiposController@show')->name('mattiposshow');
	Route::get('/materialesTipos/{id}/Form/','materialesTiposController@Form');
	Route::post('/materialesTipos/insert/','materialesTiposController@insertForm')->name('mattiposinsertForm');
	//ACEROS
	Route::get('/materialesAceros/show','materialesAcerosController@show')->name('matacerosshow');
	Route::get('/materialesAceros/{id}/Form/','materialesAcerosController@Form');
	Route::post('/materialesAceros/insert/','materialesAcerosController@insertForm')->name('matacerosinsertForm');

	//ORDENES DE COMPRA
	Route::get('/ordenCompra/crear','ordenesCompraController@crear')->name('ordenCompraCrear');
	Route::get('/ordenesCompra/show','ordenesCompraController@show')->name('ordshow');
	Route::post('/ordenCompra/insertar','ordenesCompraController@insertar');
	//MATERIALES
	Route::get('/materiales/show','materialesController@show')->name('matshow');
	Route::get('/material/crear/','materialesController@crear')->name('matCrear');
	Route::post('/material/insertar/','materialesController@insertar')->name('insertarMaterial');
	Route::get('/material/{id}/editar','materialesController@editar');
	Route::post('/material/actualizar','materialesController@actualizar');

	//NOMINA
	Route::get('/nominas/show','nominasController@show')->name('nomshow');
	Route::get('/nomina/crear','nominasController@crear');
	Route::get('/nomina/{id}/llenar','nominasController@llenar');
	Route::post('/nomina/insertarHrsExtra', 'nominasController@insertarHrsExtra');
	Route::post('/nomina/insertarFaltas', 'nominasController@insertarFaltas');
	Route::post('/nomina/insertarRetardos', 'nominasController@insertarRetardos');
	Route::get('/nomina/{id}/perfil','nominasController@perfilNomina');


	//CONFIGURACION
	Route::get('/configuracion/show','configuracionController@show')->name('conshow');
	Route::post('/configuracion/vincularUserEmpleado','configuracionController@vincularUserEmpleado');

	Route::get('/configuracion/usuarios/show','usuariosController@show')->name('usushow');
	Route::get('/configuracion/usuario/{id}/eliminar','usuariosController@eliminar');
	Route::get('/configuracion/usuario/crear','usuariosController@crear');
	Route::post('/configuracion/usuario/insertar','usuariosController@insertar')->name('insertarUsuario');
	Route::get('/configuracion/usuario/{id}/getUsuario','usuariosController@getUsuario');
	Route::post('/configuracion/usuario/actualizar','usuariosController@actualizarUsuario')->name('actualizarUsuario');




	//PROVEEDORES
	Route::get('/proveedores/show','proveedoresController@show')->name('proshow');
	Route::get('/proveedor/{id}/perfil','proveedoresController@perfilProveedor');
	Route::get('/proveedor/{id}/editar','proveedoresController@editar');
	Route::get('/proveedor/crear','proveedoresController@crear');
	Route::post('/proveedor/insertar','proveedoresController@insertar')->name('insertarProveedor');

	Route::post('/proveedor/actualizar','proveedoresController@actualizar')->name('actualizarProveedor');
	Route::get('/proveedor/{id}/eliminar','proveedoresController@eliminar');

	//ALMACEN
	Route::get('/almacen/show', 'almacenController@show')->name('almshow');

	//COTIZACIONES
	Route::get('/cotizaciones/crearCotizacion', 'cotizacionesController@crearForm');
	Route::post('/cotizaciones/insertarCotizacion', 'cotizacionesController@insertarCotizacion')->name('insertarCotizacion');
	Route::get('/cotizaciones/{id}/cotizacionesProyecto', 'cotizacionesController@cotizacionesPorProyecto');
	Route::get('/cotizaciones/{id}/nuevaCotizacionPorTrabajo', 'cotizacionesController@nuevaCotizacionDirecto');
	//Route::get('/cotizaciones/{id}/nuevaCotizacionPersonalizadaPorTrabajo', 'cotizacionesController@nuevaCotizacionPersonalizadaDirecto');
	Route::get('/cotizaciones/{id}/editar', 'cotizacionesController@editarCotizacionForm');
	Route::post('/cotizaciones/{id}/actualizarCotizacion', 'cotizacionesController@actualizarCotizacion');
	Route::get('/cotizaciones/{id}/eliminar', 'cotizacionesController@eliminarCotizacion');
	Route::get('/cotizaciones/{id}/imprimirCotizacion', 'cotizacionesController@imprimirFactura');
	Route::get('/cotizaciones/imprimirGrupos', 'cotizacionesController@imprimirGrupos');
	Route::get('/cotizaciones/{id}/enviarCotizacion', 'cotizacionesController@enviarCotizacion');
	Route::post('/cotizaciones/guardarDescripcion', 'cotizacionesController@guardarDescripcionTrabajo');
	Route::post('/cotizaciones/guardarDescripcionIndividual', 'cotizacionesController@guardarDescripcionIndividual');
	Route::post('/cotizaciones/guardarTipoCambio', 'cotizacionesController@guardarTipoCambio');
	Route::post('/cotizaciones/guardarUnidadMedidaCotizacion','cotizacionesController@guardarUnidadMedidaCotizacion');
	Route::post('/cotizaciones/guardarCantidadCotizacion','cotizacionesController@guardarCantidadCotizacion');

	//TRABAJOS
	Route::get('/trabajos/show', 'trabajosController@show')->name('trashow');
	Route::get('/trabajo/crear', 'trabajosController@crearForm');
	Route::post('/trabajo/insertar', 'trabajosController@insertarTrabajo');
	Route::post('/trabajo/insertarProceso', 'trabajosController@insertarProceso');
	Route::post('/trabajo/insertarPagoStatus', 'trabajosController@insertarPagoStatus');
	Route::post('/trabajo/guardarNotas', 'trabajosController@guardarNotas');
	Route::get('/proyecto/{id}/editar', 'trabajosController@editarProyecto');
	Route::post('/trabajo/{id}/actualizarTrabajo', 'trabajosController@actualizarProyecto');
	Route::get('/trabajos/filtroProyectos', 'trabajosController@filtarProyectos');
	Route::get('/trabajos/busquedaPorNumeroTrabajo','trabajosController@busquedaPorNumeroTrabajo');
	Route::post('/trabajo/guardarOrdenCompra', 'trabajosController@guardarOrdenCompra');
	Route::post('/trabajo/guardarNumeroFactura', 'trabajosController@guardarNumeroFactura');



	//CLIENTES
	Route::get('/clientes/show', 'clientesController@show')->name('clishow');
	Route::get('/cliente/crear', 'clientesController@crearForm');
	Route::post('/cliente/insertar', 'clientesController@insertarCliente');
	Route::get('/cliente/{id}/perfilCliente', 'clientesController@perfilCliente');
	Route::get('/cliente/{id}/editarCliente', 'clientesController@editarCliente');
	Route::post('/cliente/{id}/actualizarCliente', 'clientesController@actualizarCliente');



	//HISTORIAL DE TRANSACCIONES DE ALMACEN
	Route::get('/historialAlmacenFiltro','historialTransaccionesController@historialAlmacenFiltro')->name('historialAlmacenFiltro');
	Route::get('/historialAlmacen/show', 'historialTransaccionesController@show')->name('histshow');
	Route::get('/historialAlmacen/{id}/perfilTransaccion', 'historialTransaccionesController@perfilTransaccion');

	//ENTRADAS DE ALMACEN
	Route::get('/entradasAlmacen/show', 'entradasAlmacenController@show')->name('entradasshow');
	Route::post('/entradasAlmacen/articulosSeleccionados', 'entradasAlmacenController@articulosSeleccionados')->name('enviarArticulosSeleccionadosEntradas');

	//SALIDAS DE ALMACEN
	Route::get('/salidasAlmacen/show', 'salidasAlmacenController@show')->name('salidasshow');
	Route::post('/salidasAlmacen/articulosSeleccionados', 'salidasAlmacenController@articulosSeleccionados')->name('enviarArticulosSeleccionados');

	//ARTICULOS
	Route::get('/articulos/show', 'articulosController@show')->name('artshow');
	Route::get('/articulos/crear', 'articulosController@crearForm')->name('artCrear');
	Route::post('/articulos/insertar', 'articulosController@insertarArticulo')->name('insertarArticulo');
	Route::get('/articulo/{id}/perfilArticulo','articulosController@perfilArticulo');
	Route::get('/articulo/{id}/eliminar','articulosController@eliminarArticulo');
	Route::get('/articulo/{id}/editar','articulosController@getArticulo');
	Route::post('/articulo/{id}/actualizar','articulosController@actualizarArticulo');

	//EMPLEADOS
	Route::get('/empleado/{id}/comentar','empleadosController@insertarComentario');
	Route::post('/insertarRate','empleadosController@insertarRate');
	Route::get('/empleados/show', 'empleadosController@show')->name('empshow');
	Route::get('/empleado/crear', 'empleadosController@crearForm');
	Route::post('/empleado/insertar', 'empleadosController@insertarEmpleado')->name('insertarEmpleado');
	Route::get('/empleado/{id}/perfil','empleadosController@empleadoPerfil');
	Route::get('/historialAlmacen/empleado/{id}/perfil','empleadosController@empleadoPerfil');
	Route::get('/empleado/{id}/eliminar','empleadosController@eliminarEmpleado');
	Route::get('/empleado/{id}/editar','empleadosController@getEmpleado');
	Route::post('/empleado/{id}/actualizar','empleadosController@actualizarEmpleado');
	Route::get('/empleado/bajas', 'empleadosController@getBajasEmpleados');
	Route::get('/empleado/{id}/perfilBaja','empleadosController@empleadoPerfilBaja');
	Route::get('/empleado/{id}/alta','empleadosController@altaEmpleado');
	Route::get('/empleado/{id}/crearAmonestacion','empleadosController@crearAmonestacion');
	Route::post('/empleado/insertarAmonestacion', 'empleadosController@insertarAmonestacion')->name('insertarAmonestacion');
	Route::get('/amonestacion/{id}/editar','empleadosController@getAmonestacion');
	Route::post('/amonestacion/{id}/actualizarAmonestacion', 'empleadosController@actualizarAmonestacion');
	Route::get('/amonestacion/{id}/imprimir', 'empleadosController@imprimirAmonestacion');
	Route::get('/empleado/{id}/crearDeuda','empleadosController@crearDeuda');
	Route::post('/empleado/insertarDeuda', 'empleadosController@insertarDeuda');
	Route::get('/empleado/deuda/{id}/editar', 'empleadosController@editarDeuda');


	//MAQUINARIA
	Route::get('/maquinaria/show', 'maquinariaController@show')->name('maqshow');
	Route::get('/maquinaria/crear', 'maquinariaController@crearForm');
	Route::post('/maquinaria/insertar', 'maquinariaController@insertarMaquinaria')->name('insertarMaquinaria');
	Route::get('/maquinaria/{id}/eliminar','maquinariaController@eliminarMaquinaria');
	Route::get('/maquinaria/{id}/editar','maquinariaController@getMaquinaria');
	Route::post('/maquinaria/{id}/actualizar','maquinariaController@actualizarMaquinaria');
	Route::get('/categoriasFiltro','maquinariaController@categoriasFiltro');
	Route::get('/maquinariaBusqueda','maquinariaController@maquinariaBusqueda');

});