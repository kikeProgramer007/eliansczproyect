<?php

namespace App\Providers;

use App\Models\Rol_permiso;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        view()->composer('sidebar.administrador', function($view){
            $roles_permisos_del_usuario = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [3, 6, 8, 11, 14, 22, 25, 29, 32, 37, 40, 43, 48, 55, 58, 59, 60, 62, 65])->where('condicion', 1)->get();
            $listarMarca = false;
            $listarCategoria = false;
            $listarMaterial = false;
            $listarTalla = false;
            $listarProducto = false;
            $listarProveedor = false;
            $listarNotaCompra = false;
            $listarCliente = false;
            $listarNotaVenta = false;
            $listarNotaSalida = false;
            $listarReporteCompra = false;
            $listarReporteVenta = false;
            $listarRol = false;
            $listarUsuario = false;
            $listarBitacora = false;
            $listarEscritorio1 = false;
            $listarEscritorio2 = false;
            $listarPermiso = false;
            $listarReporteSalida = false;
            foreach ($roles_permisos_del_usuario as $item) {
                if($item->idpermiso == 3){
                    $listarMarca = true;
                }
                if($item->idpermiso == 6){
                    $listarCategoria = true;
                }
                if($item->idpermiso == 8){
                    $listarMaterial = true;
                }
                if($item->idpermiso == 11){
                    $listarTalla = true;
                }
                if($item->idpermiso == 14){
                    $listarProducto = true;
                }
                if($item->idpermiso == 22){
                    $listarProveedor = true;
                }
                if($item->idpermiso == 25){
                    $listarNotaCompra = true;
                }
                if($item->idpermiso == 29){
                    $listarCliente = true;
                }
                if($item->idpermiso == 32){
                    $listarNotaVenta = true;
                }
                if($item->idpermiso == 37){
                    $listarNotaSalida = true;
                }
                if($item->idpermiso == 40){
                    $listarReporteCompra = true;
                }
                if($item->idpermiso == 43){
                    $listarReporteVenta = true;
                }
                if($item->idpermiso == 48){
                    $listarRol = true;
                }
                if($item->idpermiso == 55){
                    $listarUsuario = true;
                }
                if($item->idpermiso == 58){
                    $listarBitacora = true;
                }
                if($item->idpermiso == 59){
                    $listarEscritorio1 = true;
                }
                if($item->idpermiso == 60){
                    $listarEscritorio2 = true;
                }
                if($item->idpermiso == 62){
                    $listarPermiso = true;
                }
                if($item->idpermiso == 65){
                    $listarReporteSalida = true;
                }
            }
            $view->with(['listarMarca' => $listarMarca, 'listarCategoria' => $listarCategoria, 
            'listarMaterial' => $listarMaterial, 'listarTalla' => $listarTalla, 'listarProducto' => $listarProducto, 
            'listarProveedor' => $listarProveedor, 'listarNotaCompra' => $listarNotaCompra, 'listarCliente' => $listarCliente, 
            'listarNotaVenta' => $listarNotaVenta, 'listarNotaSalida' => $listarNotaSalida, 'listarReporteCompra' => $listarReporteCompra, 
            'listarReporteVenta' => $listarReporteVenta, 'listarRol' => $listarRol, 'listarUsuario' => $listarUsuario, 
            'listarBitacora' => $listarBitacora, 'listarEscritorio1' => $listarEscritorio1, 'listarEscritorio2' => $listarEscritorio2, 
            'listarPermiso' => $listarPermiso, 'listarReporteSalida' => $listarReporteSalida]);
        });
    }
}
