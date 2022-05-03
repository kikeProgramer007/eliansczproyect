<?php

use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NotaCompraController;
use App\Http\Controllers\NotaVentaController;
use App\Http\Controllers\NotaSalidaController;
use App\Http\Controllers\TallaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\TallaProductoController;
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
    return view('login');
})->name('/');

Route::post('login', [LoginController::class, 'login']);
Route::get('login/olvidar_contraseña', [LoginController::class, 'olvidar_contraseña']);
Route::post('login/nueva_contraseña', [LoginController::class, 'nueva_contraseña']);

Route::middleware(['auth'])->group(function () {

    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('perfil/{id}', [LoginController::class, 'editar_perfil']);
    
    // Route::post('login/nueva_contraseña', [LoginController::class, 'nueva_contraseña']);
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('dashboard2', [DashboardController::class, 'index2']);
    Route::get('dashboard/calcular', [DashboardController::class, 'calcular']);
    Route::get('chartjs', [DashboardController::class, 'chartjs'])->name('chartjs.index');

   //Roles
    Route::get('roles', [RolController::class, 'index']);
    Route::get('rol/create', [RolController::class, 'create']);
    Route::post('rol/create', [RolController::class, 'store']);
    Route::post('rol/desactivar', [RolController::class, 'desactivar']);
    Route::post('rol/activar', [RolController::class, 'activar']);
    Route::get('rol/edit/{id}', [RolController::class, 'edit']);
    Route::post('rol/update', [RolController::class, 'update']);
    Route::get('rol/ver/{id}', [RolController::class, 'ver']);

    //Roles_permisos
    Route::post('rol_permiso/update', [RolController::class, 'updateRolPermiso']);

    //Users
    Route::get('users', [UserController::class, 'index']);
    Route::get('user/create', [UserController::class, 'create']);
    Route::post('user/create', [UserController::class, 'store']);
    Route::get('user/edit/{id}', [UserController::class, 'edit']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::post('user/updateperfil', [UserController::class, 'updateperfil']);
    Route::post('user/desactivar', [UserController::class, 'desactivar']);
    Route::post('user/activar', [UserController::class, 'activar']);
    Route::get('user/busqueda', [UserController::class, 'busqueda']);

    //Clientes
    Route::get('clientes', [ClienteController::class, 'index']);
    Route::get('cliente/create', [ClienteController::class, 'create']);
    Route::post('cliente/create', [ClienteController::class, 'store']);
    Route::get('cliente/edit/{id}', [ClienteController::class, 'edit']);
    Route::post('cliente/update', [ClienteController::class, 'update']);
    Route::get('cliente/busqueda', [ClienteController::class, 'busqueda']);

    //Marcas
    Route::get('marcas', [MarcaController::class, 'index']);
    Route::get('marca/create', [MarcaController::class, 'create']);
    Route::post('marca/create', [MarcaController::class, 'store']);
    Route::get('marca/edit/{id}', [MarcaController::class, 'edit']);
    Route::post('marca/update', [MarcaController::class, 'update']);
    Route::get('marca/busqueda', [MarcaController::class, 'busqueda']);

    //Categorias
    Route::get('categorias', [CategoriaController::class, 'index']);
    Route::get('categoria/create', [CategoriaController::class, 'create']);
    Route::post('categoria/create', [CategoriaController::class, 'store']);
    Route::get('categoria/edit/{id}', [CategoriaController::class, 'edit']);
    Route::post('categoria/update', [CategoriaController::class, 'update']);
    Route::get('categoria/busqueda', [CategoriaController::class, 'busqueda']);

    //Materiales
    Route::get('materiales', [MaterialController::class, 'index']);
    Route::get('material/create', [MaterialController::class, 'create']);
    Route::post('material/create', [MaterialController::class, 'store']);
    Route::get('material/edit/{id}', [MaterialController::class, 'edit']);
    Route::post('material/update', [MaterialController::class, 'update']);
    Route::get('material/busqueda', [MaterialController::class, 'busqueda']);

    //Tallas
    Route::get('tallas', [TallaController::class, 'index']);
    Route::get('talla/create', [TallaController::class, 'create']);
    Route::post('talla/create', [TallaController::class, 'store']);
    Route::get('talla/edit/{id}', [TallaController::class, 'edit']);
    Route::post('talla/update', [TallaController::class, 'update']);
    Route::get('talla/busqueda', [TallaController::class, 'busqueda']);

    //Productos
    Route::get('productos', [ProductoController::class, 'index']);
    Route::get('producto/create', [ProductoController::class, 'create']);
    Route::post('producto/create', [ProductoController::class, 'store']);
    Route::get('producto/edit/{id}', [ProductoController::class, 'edit']);
    Route::get('producto/ver/{id}', [ProductoController::class, 'ver']);
    Route::post('producto/update', [ProductoController::class, 'update']);
    Route::post('producto/desactivar', [ProductoController::class, 'desactivar']);
    Route::post('producto/activar', [ProductoController::class, 'activar']);
    Route::get('producto/busqueda', [ProductoController::class, 'busqueda']);

    //TallaProductos
    Route::post('tallaproducto/update', [ProductoController::class, 'updateTallaProducto']);
    Route::get('tallaproducto/ver/{id}', [TallaProductoController::class, 'ver']);
    Route::post('tallaproducto/updatestock', [TallaProductoController::class, 'update']);

    //Notas de ventas
    Route::get('notasventas', [NotaVentaController::class, 'index']);
    Route::get('reportesventas', [NotaVentaController::class, 'index_reporte']);
    Route::get('notaventa/create', [NotaVentaController::class, 'create']);
    Route::post('notaventa/store', [NotaVentaController::class, 'store']);
    Route::get('notaventa/ver/{id}', [NotaVentaController::class, 'ver']);
    Route::get('notaventa/ver_reporte/{id}', [NotaVentaController::class, 'ver_reporte']);
    Route::post('notaventa/desactivar', [NotaVentaController::class, 'desactivar']);
    Route::get('notaventa/busqueda', [NotaVentaController::class, 'busqueda']);
    Route::get('notaventa/busqueda_reporte', [NotaVentaController::class, 'busqueda_reporte']);
    Route::get('notaventa/pdf/{id}', [NotaVentaController::class, 'pdf'])->name('pdfVenta');
    Route::get('notaventa/excel/{year}', [NotaVentaController::class, 'excel']);
    

    //Notas de salida
    Route::get('notassalidas', [NotaSalidaController::class, 'index']);
    Route::get('notasalida/create', [NotaSalidaController::class, 'create']);
    Route::post('notasalida/store', [NotaSalidaController::class, 'store']);
    Route::get('notasalida/ver/{id}', [NotaSalidaController::class, 'ver']);
    Route::post('notasalida/desactivar', [NotaSalidaController::class, 'desactivar']);
    Route::get('notasalida/busqueda', [NotaSalidaController::class, 'busqueda']);
    Route::get('reportessalidas', [NotaSalidaController::class, 'index_reporte']);
    Route::get('notasalida/ver_reporte/{id}', [NotaSalidaController::class, 'ver_reporte']);
    Route::get('notasalida/busqueda_reporte', [NotaSalidaController::class, 'busqueda_reporte']);
    Route::get('notasalida/excel/{year}', [NotaSalidaController::class, 'excel']);

    //Proveedores
    Route::get('proveedores', [ProveedorController::class, 'index']);
    Route::get('proveedor/create', [ProveedorController::class, 'create']);
    Route::post('proveedor/create', [ProveedorController::class, 'store']);
    Route::get('proveedor/edit/{id}', [ProveedorController::class, 'edit']);
    Route::post('proveedor/update', [ProveedorController::class, 'update']);
    Route::get('proveedor/busqueda', [ProveedorController::class, 'busqueda']);

    //Notas de compras
    Route::get('notascompras', [NotaCompraController::class, 'index']);
    Route::get('reportescompras', [NotaCompraController::class, 'index_reporte']);
    Route::get('notacompra/create', [NotaCompraController::class, 'create']);
    Route::post('notacompra/store', [NotaCompraController::class, 'store']);
    Route::get('notacompra/ver/{id}', [NotaCompraController::class, 'ver']);
    Route::get('notacompra/ver_reporte/{id}', [NotaCompraController::class, 'ver_reporte']);
    Route::post('notacompra/desactivar', [NotaCompraController::class, 'desactivar']);
    Route::get('notacompra/busqueda', [NotaCompraController::class, 'busqueda']);
    Route::get('notacompra/busqueda_reporte', [NotaCompraController::class, 'busqueda_reporte']);
    Route::get('notacompra/excel/{year}', [NotaCompraController::class, 'excel']);

    //Permisos
    Route::get('permisos', [PermisoController::class, 'index']);
    Route::get('permiso/edit/{id}', [PermisoController::class, 'edit']);
    Route::post('permiso/update', [PermisoController::class, 'update']);
    Route::get('permiso/busqueda', [PermisoController::class, 'busqueda']);

    //Bitacora
    Route::get('bitacoras', [BitacoraController::class, 'index']);
    Route::get('bitacora/busqueda', [BitacoraController::class, 'busqueda']);
});