<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DetalleNotaVenta as ControllersDetalleNotaVenta;
use App\Models\Bitacora;
use App\Models\Detallenotasalida;
use App\Models\Producto;
use App\Models\Notasalida;
use App\Models\Rol_permiso;
use App\Models\Tallaproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\NotasalidaExport;

class NotaSalidaController extends Controller
{
    public function index(){
        $notassalidas = NotaSalida::with('user')->paginate(4);
        // dd(json_decode(json_encode($notasventas)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [36, 37, 38, 39])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $cambiarEstado = false;
        $ver = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 36){
                $crear = true;
            }
            if($item->idpermiso == 37){
                $listar = true;
            }
            if($item->idpermiso == 38){
                $cambiarEstado = true;
            }
            if($item->idpermiso == 39){
                $ver = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('notasalida.index', ['notassalidas' => $notassalidas], compact('crear', 'listar', 'cambiarEstado', 'ver'));
    }

    public function index_reporte(){
        $notassalidas = Notasalida::with('user')->where('condicion', 1)->paginate(4);
        // dd(json_decode(json_encode($notascompras)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [65, 66, 67])->where('condicion', 1)->get();
        $listar = false;
        $generar = false;
        $ver = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 65){
                $listar = true;
            }
            if($item->idpermiso == 67){
                $generar = true;
            }
            if($item->idpermiso == 66){
                $ver = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('reportends.index', ['notassalidas' => $notassalidas], compact('listar', 'generar', 'ver'));
    }

    public function create(){
        $tallasproductos = Tallaproducto::where('condicion', 1)->where('stock', '>', 0)->with('producto')->with('talla')->get();
        //$tallasproductos = Tallaproducto::join('producto', 'tallaproducto.idproducto', 'producto.id')->where('tallaproducto.condicion', 1)->where('producto.condicion', 1)->with('talla')->get();
        // dd(json_decode(json_encode($tallasproductos)));
        return view('notasalida.create', ['tallasproductos' => $tallasproductos]);
    }

    public function busqueda(Request $request){
        try {
            if($request->input('opcion') == 'user'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [36, 37, 38, 39])->where('condicion', 1)->get();
                $crear = false;
                $listar = false;
                $cambiarEstado = false;
                $ver = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 36){
                        $crear = true;
                    }
                    if($item->idpermiso == 37){
                        $listar = true;
                    }
                    if($item->idpermiso == 38){
                        $cambiarEstado = true;
                    }
                    if($item->idpermiso == 39){
                        $ver = true;
                    }
                }
                $notassalidas = Notasalida::join('users', 'notasalida.idusuario', 'users.id')
                ->join('personal', 'users.idpersonal', 'personal.id')
                ->where('personal.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();

                $ids_users = array();
                foreach ($notassalidas as $value) {
                    array_push($ids_users, $value->idusuario);
                }

                $notassalidas = Notasalida::whereIn('idusuario', $ids_users)->with('user')->paginate(4);

                $view = view('notasalida.datos', compact('notassalidas', 'crear', 'listar', 'cambiarEstado', 'ver'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function busqueda_reporte(Request $request){
        try {
            if($request->input('opcion') == 'user'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [65, 66, 67])->where('condicion', 1)->get();
                $listar = false;
                $generar = false;
                $ver = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 65){
                        $listar = true;
                    }
                    if($item->idpermiso == 67){
                        $generar = true;
                    }
                    if($item->idpermiso == 66){
                        $ver = true;
                    }
                }
                if($request->input('texto') == ''){
                    $notassalidas = Notasalida::join('users', 'notasalida.idusuario', 'users.id')
                    ->join('personal', 'users.idpersonal', 'personal.id')
                    ->where('personal.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();

                    $ids_users = array();
                    foreach ($notassalidas as $value) {
                        array_push($ids_users, $value->idusuario);
                    }

                    $notassalidas = Notasalida::whereIn('idusuario', $ids_users)->with('user')->where('notasalida.condicion', 1)
                    ->paginate(4);

                    $view = view('reportends.datos', compact('notassalidas', 'listar', 'generar', 'ver'))->render();
                    return response()->json(['view' => $view], 200);
                }else{
                    $notassalidas = Notasalida::join('users', 'notasalida.idusuario', 'users.id')
                    ->join('personal', 'users.idpersonal', 'personal.id')
                    ->where('personal.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();

                    $ids_users = array();
                    foreach ($notassalidas as $value) {
                        array_push($ids_users, $value->idusuario);
                    }

                    $notassalidas = Notasalida::whereIn('idusuario', $ids_users)->whereBetween('created_at', [$request->desde, $request->hasta])->with('user')->where('condicion', 1)
                    ->paginate(4);

                    $view = view('reportends.datos', compact('notassalidas', 'listar', 'generar', 'ver'))->render();
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
            $errores = Notasalida::store($request);
            if($errores != ''){
                DB::rollBack();
                return response()->json(['mensaje' => $errores], 500);
            }
            DB::commit();
            return response()->json(['mensaje' => 'Nota de salida creada exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    //ver en el detalle de la nota de salida
    public function ver($idnotasalida){
        $detallesnotassalidas = Detallenotasalida::where('idnotasalida', $idnotasalida)->with('tallaproducto')->get();
        // dd(json_decode(json_encode($detallesnotasventas)));
        $notassalidas = Notasalida::find($idnotasalida);
        return view('notasalida.ver', ['detallesnotassalidas' => $detallesnotassalidas, 'notassalidas' => $notassalidas]);
    }

    public function ver_reporte($idnotasalida){
        $detallesnotassalidas = Detallenotasalida::where('idnotasalida', $idnotasalida)->with('tallaproducto')->get();
        // dd(json_decode(json_encode($detallesnotascompras)));
        $notassalidas = Notasalida::find($idnotasalida);
        return view('reportends.ver', ['detallesnotassalidas' => $detallesnotassalidas, 'notassalidas' => $notassalidas]);
    }

    public function desactivar(Request $request){
        try {
            DB::beginTransaction();
            $notasalida = Notasalida::findOrFail($request->input('id'));
            $notasalida->condicion = 0;
            $notasalida->update();
            
            $notassalidas = Notasalida::find($notasalida->id);
            $detallesnotassalidas = Detallenotasalida::where('idnotasalida', $notassalidas->id)->get();
            //dd(json_decode(json_encode($detallesnotasventas)));
            foreach ($detallesnotassalidas as $detalle) {
                $obtener_tallaproducto_de_db = Tallaproducto::find($detalle->idtallaproducto);
                $obtener_tallaproducto_de_db->stock = $obtener_tallaproducto_de_db->stock + $detalle->cantidad;
                $obtener_tallaproducto_de_db->update();
            }

            $bitacora = new Bitacora();
            $bitacora->accion = 'Desactivar';
            $bitacora->tabla = 'Nota de salida';
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();
            
            DB::commit();
            return  response()->json(['mensaje' => 'Producto devuelto...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function excel($year){
        //return Excel::download(new NotaventaExport, 'lista_notaventa.xlsx');
        $bitacora = new Bitacora();
        $bitacora->accion = 'Generar Excel';
        $bitacora->tabla = 'Reporte de salida';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();

        return (new NotasalidaExport)->forYear($year)->download('lista_notasalida_'.$year.'.xlsx');
    }
}
