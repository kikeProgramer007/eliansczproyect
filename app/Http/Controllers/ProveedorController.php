<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Rol_permiso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index(){
        $proveedores = Proveedor::paginate(4);
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [21, 22, 23])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $editar = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 21){
                $crear = true;
            }
            if($item->idpermiso == 22){
                $listar = true;
            }
            if($item->idpermiso == 23){
                $editar = true;
            }
        }
        return view('proveedor.index', ['proveedores' => $proveedores], compact('crear', 'listar', 'editar'));
    }

    public function busqueda(Request $request){
        try {
            $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [21, 22, 23])->where('condicion', 1)->get();
            $crear = false;
            $listar = false;
            $editar = false;
            foreach ($permisos_de_este_rol as $item) {
                if($item->idpermiso == 21){
                    $crear = true;
                }
                if($item->idpermiso == 22){
                    $listar = true;
                }
                if($item->idpermiso == 23){
                    $editar = true;
                }
            }
            if($request->input('opcion') == 'nombre'){
                $proveedores = Proveedor::select('proveedor.id', 'proveedor.nombre', 'proveedor.direccion', 'proveedor.telefono', 'proveedor.correo')
                ->where('proveedor.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(4);
                $view = view('proveedor.datos', compact('proveedores', 'crear', 'listar', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
            if($request->input('opcion') == 'telefono'){
                $proveedores = Proveedor::select('proveedor.id', 'proveedor.nombre', 'proveedor.direccion', 'proveedor.telefono', 'proveedor.correo')
                ->where('proveedor.telefono', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(4);

                $view = view('proveedor.datos', compact('proveedores', 'crear', 'listar', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function create(){
        $proveedores = Proveedor::where('id')->get();
        return view('proveedor.create', ['proveedores' => $proveedores]);
    }
    
    public function store(Request $request){
        try {
            DB::beginTransaction();
            Proveedor::store($request);
            DB::commit();
            return redirect()->to('proveedores')->with('message', 'Proveedor creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('proveedores')->with('error', $e->getMessage());
        }
    }
    
    
    public function edit($id){
        $proveedor = Proveedor::select('proveedor.id', 'proveedor.nombre', 'proveedor.direccion', 'proveedor.telefono', 'proveedor.correo')
        ->where('proveedor.id', $id)
        ->first();
        return view('proveedor.edit', ['proveedor' => $proveedor]);
    }
    
    public function update(Request $request){
        
        try {
            DB::beginTransaction();
            Proveedor::actualizar($request);
            DB::commit();
            return redirect()->to('proveedores')->with('message', 'Proveedor actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('proveedores')->with('error', $e->getMessage());
        }
    }
}
