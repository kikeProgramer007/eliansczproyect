<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Rol_permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller
{
    public function index(){
        $permisos = Permiso::paginate(4);
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [61, 62, 63, 64])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $cambiarEstado = false;
        $editar = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 61){
                $crear = true;
            }
            if($item->idpermiso == 62){
                $listar = true;
            }
            if($item->idpermiso == 63){
                $cambiarEstado = true;
            }
            if($item->idpermiso == 64){
                $editar = true;
            }
        }
        return view('permiso.index', ['permisos' => $permisos],  compact('crear', 'listar', 'cambiarEstado', 'editar'));
    }

    public function busqueda(Request $request){
        try {
            if($request->input('opcion') == 'nombre'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [61, 62, 63, 64])->where('condicion', 1)->get();
                $crear = false;
                $listar = false;
                $cambiarEstado = false;
                $editar = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 61){
                        $crear = true;
                    }
                    if($item->idpermiso == 62){
                        $listar = true;
                    }
                    if($item->idpermiso == 63){
                        $cambiarEstado = true;
                    }
                    if($item->idpermiso == 64){
                        $editar = true;
                    }
                }
                $permisos = Permiso::select('permiso.id', 'permiso.nombre', 'permiso.condicion')
                ->where('permiso.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(4);
                $view = view('permiso.datos', compact('permisos', 'crear', 'listar', 'cambiarEstado', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    
    public function edit($id){
        $permiso = Permiso::select('permiso.id', 'permiso.nombre')
        ->where('permiso.id', $id)
        ->first();
        return view('permiso.edit', ['permiso' => $permiso]);
    }

    public function update(Request $request){
        try {
            DB::beginTransaction();
            Permiso::actualizar($request);
            DB::commit();
            return redirect()->to('permisos')->with('message', 'Permiso actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('permisos')->with('error', $e->getMessage());
        }
    }

}
