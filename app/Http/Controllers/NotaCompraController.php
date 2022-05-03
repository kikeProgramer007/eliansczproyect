<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Notacompra;
use App\Models\Detallenotacompra;
use App\Models\Tallaproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\NotacompraExport;
use App\Models\Rol_permiso;

class NotaCompraController extends Controller
{
    public function index(){
        $notascompras = Notacompra::with('proveedor')->with('user')->paginate(4);
        // dd(json_decode(json_encode($notascompras)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [24, 25, 26, 27])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $cambiarEstado = false;
        $ver = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 24){
                $crear = true;
            }
            if($item->idpermiso == 25){
                $listar = true;
            }
            if($item->idpermiso == 27){
                $cambiarEstado = true;
            }
            if($item->idpermiso == 26){
                $ver = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('notacompra.index', ['notascompras' => $notascompras], compact('crear', 'listar', 'cambiarEstado', 'ver'));
    }

    public function index_reporte(){
        $notascompras = Notacompra::with('proveedor')->with('user')->where('condicion', 1)->paginate(4);
        // dd(json_decode(json_encode($notascompras)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [40, 41, 42])->where('condicion', 1)->get();
        $listar = false;
        $generar = false;
        $ver = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 40){
                $listar = true;
            }
            if($item->idpermiso == 42){
                $generar = true;
            }
            if($item->idpermiso == 41){
                $ver = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('reportendc.index', ['notascompras' => $notascompras], compact('listar', 'generar', 'ver'));
    }

    public function create(){
        $tallasproductos = Tallaproducto::where('condicion', 1)->with('producto')->with('talla')->get();
        //$tallasproductos = Tallaproducto::join('producto', 'tallaproducto.idproducto', 'producto.id')->where('tallaproducto.condicion', 1)->where('producto.condicion', 1)->with('talla')->get();
        // dd(json_decode(json_encode($tallasproductos)));
        $proveedores = Proveedor::get();
        return view('notacompra.create', ['proveedores' => $proveedores, 'tallasproductos' => $tallasproductos]);
    }

    public function busqueda(Request $request){
        try {
            if($request->input('opcion') == 'proveedor'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [24, 25, 26, 27])->where('condicion', 1)->get();
                $crear = false;
                $listar = false;
                $cambiarEstado = false;
                $ver = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 24){
                        $crear = true;
                    }
                    if($item->idpermiso == 25){
                        $listar = true;
                    }
                    if($item->idpermiso == 27){
                        $cambiarEstado = true;
                    }
                    if($item->idpermiso == 26){
                        $ver = true;
                    }
                }
                $notascompras = Notacompra::join('proveedor', 'notacompra.idproveedor', 'proveedor.id')->where('proveedor.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();
                
                $ids_proveedores = array();
                foreach ($notascompras as $value) {
                    array_push($ids_proveedores, $value->idproveedor);
                }

                $notascompras = Notacompra::whereIn('idproveedor', $ids_proveedores)->with('proveedor')->with('user')
                ->paginate(4);
                //dd(json_decode(json_encode($notascompras)));
                $view = view('notacompra.datos', compact('notascompras', 'crear', 'listar', 'cambiarEstado', 'ver'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function busqueda_reporte(Request $request){
        try {
            if($request->input('opcion') == 'proveedor'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [40, 41, 42])->where('condicion', 1)->get();
                $listar = false;
                $generar = false;
                $ver = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 40){
                        $listar = true;
                    }
                    if($item->idpermiso == 42){
                        $generar = true;
                    }
                    if($item->idpermiso == 41){
                        $ver = true;
                    }
                }
                if($request->input('texto') == ''){
                    $notascompras = Notacompra::join('proveedor', 'notacompra.idproveedor', 'proveedor.id')->where('proveedor.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();
                    $ids_proveedores = array();
                    foreach ($notascompras as $value) {
                        array_push($ids_proveedores, $value->idproveedor);
                    }

                    $notascompras = Notacompra::whereIn('idproveedor', $ids_proveedores)->with('proveedor')->with('user')->where('condicion', 1)
                    ->paginate(4);

                    $view = view('reportendc.datos', compact('notascompras', 'listar', 'generar', 'ver'))->render();
                    return response()->json(['view' => $view], 200);
                }else{
                    $notascompras = Notacompra::join('proveedor', 'notacompra.idproveedor', 'proveedor.id')->where('proveedor.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();
                    $ids_proveedores = array();
                    foreach ($notascompras as $value) {
                        array_push($ids_proveedores, $value->idproveedor);
                    }

                    $notascompras = Notacompra::whereIn('idproveedor', $ids_proveedores)->whereBetween('created_at', [$request->desde, $request->hasta])->with('proveedor')->with('user')->where('condicion', 1)
                    ->paginate(4);

                    $view = view('reportendc.datos', compact('notascompras', 'listar', 'generar', 'ver'))->render();
                    return response()->json(['view' => $view], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $errores = Notacompra::store($request);
            if($errores != ''){
                DB::rollBack();
                return response()->json(['mensaje' => $errores], 500);
            }
            DB::commit();
            return response()->json(['mensaje' => 'Nota de compra creada exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    //ver en el detalle de la nota de venta
    public function ver($idnotacompra){
        $detallesnotascompras = Detallenotacompra::where('idnotacompra', $idnotacompra)->with('tallaproducto')->get();
        // dd(json_decode(json_encode($detallesnotascompras)));
        $proveedores = Proveedor::get();
        $notascompras = Notacompra::find($idnotacompra);
        return view('notacompra.ver', ['proveedores' => $proveedores, 'detallesnotascompras' => $detallesnotascompras, 'notascompras' => $notascompras]);
    }

    public function ver_reporte($idnotacompra){
        $detallesnotascompras = Detallenotacompra::where('idnotacompra', $idnotacompra)->with('tallaproducto')->get();
        // dd(json_decode(json_encode($detallesnotascompras)));
        $proveedores = Proveedor::get();
        $notascompras = Notacompra::find($idnotacompra);
        return view('reportendc.ver', ['proveedores' => $proveedores, 'detallesnotascompras' => $detallesnotascompras, 'notascompras' => $notascompras]);
    }

    public function desactivar(Request $request){
        try {
            DB::beginTransaction();
            $notacompra = Notacompra::findOrFail($request->input('id'));
            $notacompra->condicion = 0;
            $notacompra->update();
            //dd(json_decode(json_encode($notacompra->id)));
            $notascompras = Notacompra::find($notacompra->id);
            //dd(json_decode(json_encode($notascompras)));
            $detallesnotascompras = Detallenotacompra::where('idnotacompra', $notascompras->id)->get();
            //dd(json_decode(json_encode($detallesnotascompras)));
            foreach ($detallesnotascompras as $detalle) {
                $obtener_tallaproducto_de_db = Tallaproducto::find($detalle->idtallaproducto);
                $obtener_tallaproducto_de_db->stock = $obtener_tallaproducto_de_db->stock - $detalle->cantidad;
                $obtener_tallaproducto_de_db->update();
            }

            $bitacora = new Bitacora();
            $bitacora->accion = 'Desactivar';
            $bitacora->tabla = 'Nota de compra';
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();
            
            DB::commit();
            return  response()->json(['mensaje' => 'Producto quitado...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function excel($year){
        //return Excel::download(new NotaventaExport, 'lista_notaventa.xlsx');
        $bitacora = new Bitacora();
        $bitacora->accion = 'Generar Excel';
        $bitacora->tabla = 'Reporte de compra';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();

        return (new NotacompraExport)->forYear($year)->download('lista_notacompra_'.$year.'.xlsx');
    }
}
