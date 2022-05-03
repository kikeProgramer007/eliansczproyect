<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Rol_permiso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index(){
        $materiales = Material::paginate(4);
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [7, 8, 9])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $editar = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 7){
                $crear = true;
            }
            if($item->idpermiso == 8){
                $listar = true;
            }
            if($item->idpermiso == 9){
                $editar = true;
            }
        }
        return view('material.index', ['materiales' => $materiales], compact('crear', 'editar', 'listar'));
    }

    public function busqueda(Request $request){
        try {
            if($request->input('opcion') == 'nombre'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [7, 8, 9])->where('condicion', 1)->get();
                $crear = false;
                $listar = false;
                $editar = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 7){
                        $crear = true;
                    }
                    if($item->idpermiso == 8){
                        $listar = true;
                    }
                    if($item->idpermiso == 9){
                        $editar = true;
                    }
                }
                $materiales = Material::select('material.id', 'material.nombre')
                ->where('material.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(4);;
                $view = view('material.datos', compact('materiales', 'crear', 'editar', 'listar'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function create(){
        $materiales = Material::where('id')->get();
        return view('material.create', ['materiales' => $materiales]);
    }
    
    public function store(Request $request){
        try {
            DB::beginTransaction();
            Material::store($request);
            DB::commit();
            return redirect()->to('materiales')->with('message', 'Material creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('materiales')->with('error', $e->getMessage());
        }
    }
    
    public function edit($id){
        $material = Material::select('material.id', 'material.nombre')
        ->where('material.id', $id)
        ->first();
        return view('material.edit', ['material' => $material]);
    }
    
    public function update(Request $request){
        try {
            DB::beginTransaction();
            Material::actualizar($request);
            DB::commit();
            return redirect()->to('materiales')->with('message', 'Material actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('materiales')->with('error', $e->getMessage());
        }
    }
}
