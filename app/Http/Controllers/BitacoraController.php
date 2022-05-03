<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Rol_permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index(){
        $bitacoras = Bitacora::with('user')->orderBy('id', 'DESC')->paginate(10);
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [58])->where('condicion', 1)->get();
        $listar = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 58){
                $listar = true;
            }
        }
        return view('bitacora.index', ['bitacoras' => $bitacoras], compact('listar'));
    }

    public function busqueda(Request $request){
        try {
            $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [58])->where('condicion', 1)->get();
            $listar = false;
            foreach ($permisos_de_este_rol as $item) {
                if($item->idpermiso == 58){
                    $listar = true;
                }
            }
            if($request->input('opcion') == 'created_at'){
                $bitacoras = Bitacora::select('bitacora.id')
                ->where('bitacora.created_at', 'LIKE', '%'.$request->input('texto').'%')
                ->get();
            }
            if($request->input('opcion') == 'accion'){
                $bitacoras = Bitacora::select('bitacora.id')
                ->where('bitacora.accion', 'LIKE', '%'.$request->input('texto').'%')
                ->get();

            }
            if($request->input('opcion') == 'user'){
                $bitacoras = Bitacora::join('users', 'bitacora.idusuario', 'users.id')
                ->join('personal', 'users.idpersonal', 'personal.id')
                ->select('bitacora.id')
                ->where('personal.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();
            }

            $ids_bitacoras = array();
            foreach ($bitacoras as $value) {
                array_push($ids_bitacoras, $value->id);
            }

            $bitacoras = Bitacora::whereIn('id', $ids_bitacoras)->with('user')->orderBy('id', 'DESC')
            ->paginate(10);

            $view = view('bitacora.datos', compact('bitacoras', 'listar'))->render();
            return response()->json(['view' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
