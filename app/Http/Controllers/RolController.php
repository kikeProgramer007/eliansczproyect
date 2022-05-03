<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Permiso;
use App\Models\Rol;
use App\Models\Rol_permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function index(){
        $roles = Rol::get();
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [47, 48, 49, 50, 51])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $cambiarEstado = false;
        $editar = false;
        $verPermiso = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 47){
                $crear = true;
            }
            if($item->idpermiso == 48){
                $listar = true;
            }
            if($item->idpermiso == 49){
                $cambiarEstado = true;
            }
            if($item->idpermiso == 50){
                $editar = true;
            }
            if($item->idpermiso == 51){
                $verPermiso = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('rol.index', ['roles' => $roles], compact('crear', 'listar', 'cambiarEstado', 'editar', 'verPermiso'));
    }

    public function create(){
        $roles = Rol::get();
        return view('rol.create', ['roles' => $roles]);
    }

    public function desactivar(Request $request){
        try {
            DB::beginTransaction();
            $rol = Rol::findOrFail($request->input('id'));
            $rol->condicion = 0;
            $rol->update();

            $bitacora = new Bitacora();
            $bitacora->accion = 'Desactivar';
            $bitacora->tabla = 'Rol';
            $bitacora->nombre_implicado = $rol->nombre;
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();

            DB::commit();
            return  response()->json(['mensaje' => 'Rol desactivado...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function activar(Request $request){
        try {
            DB::beginTransaction();
            $rol = Rol::findOrFail($request->input('id'));
            $rol->condicion = 1;
            $rol->update();

            $bitacora = new Bitacora();
            $bitacora->accion = 'Activar';
            $bitacora->tabla = 'Rol';
            $bitacora->nombre_implicado = $rol->nombre;
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();

            DB::commit();
            return  response()->json(['mensaje' => 'Rol activado...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            Rol::store($request);
            DB::commit();
            return redirect()->to('roles')->with('message', 'Rol creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('roles')->with('error', $e->getMessage());
        }
    }
    
    
    public function edit($id){
        $rol = Rol::select('rol.id', 'rol.nombre', 'rol.condicion')
        ->where('rol.id', $id)
        ->first();
        return view('rol.edit', ['rol' => $rol]);
    }
    
    public function update(Request $request){
        
        try {
            DB::beginTransaction();
            Rol::actualizar($request);
            DB::commit();
            return redirect()->to('roles')->with('message', 'Rol actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('roles')->with('error', $e->getMessage());
        }
    }

    public function ver($idrol){
        $roles_permisos = Rol_permiso::join('rol', 'rol_permiso.idrol', 'rol.id')
        ->join('permiso', 'rol_permiso.idpermiso', 'permiso.id')
        ->select('rol_permiso.id','rol_permiso.idpermiso', 'permiso.nombre as permiso_nombre')
        ->where('rol_permiso.idrol', $idrol)
        ->where('rol_permiso.condicion', 1)
        ->get();

        $rol = Rol::find($idrol);
        $permisos = Permiso::get();
        return view('rol.indexrp', ['roles_permisos' => $roles_permisos, 'rol' => $rol, 'permisos' => $permisos]);
    }

    public function updateRolPermiso(Request $request){
        try {
            DB::beginTransaction();
            Rol_permiso::updateRolpermiso($request);
            DB::commit();
            return redirect()->to('roles')->with('message', 'Rol Permiso actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->to('roles')->with('error', $e->getMessage());
        }
    }
}
