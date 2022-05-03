<?php

namespace App\Http\Controllers;

use App\Models\Rol_permiso;
use Illuminate\Http\Request;
use App\Models\Talla;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TallaController extends Controller
{
    public function index(){
        $tallas = Talla::paginate(4);
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [10, 11, 12])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $editar = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 10){
                $crear = true;
            }
            if($item->idpermiso == 11){
                $listar = true;
            }
            if($item->idpermiso == 12){
                $editar = true;
            }
        }
        return view('talla.index', ['tallas' => $tallas], compact('crear', 'editar', 'listar'));
    }

    public function busqueda(Request $request){
        try {
            if($request->input('opcion') == 'nombre'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [10, 11, 12])->where('condicion', 1)->get();
                $crear = false;
                $listar = false;
                $editar = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 10){
                        $crear = true;
                    }
                    if($item->idpermiso == 11){
                        $listar = true;
                    }
                    if($item->idpermiso == 12){
                        $editar = true;
                    }
                }
                $tallas = Talla::select('talla.id', 'talla.nombre')
                ->where('talla.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(4);
                $view = view('talla.datos', compact('tallas', 'crear', 'editar', 'listar'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function create(){
        $tallas = Talla::where('id')->get();
        return view('talla.create', ['tallas' => $tallas]);
    }
    
    public function store(Request $request){
        try {
            DB::beginTransaction();
            Talla::store($request);
            DB::commit();
            return redirect()->to('tallas')->with('message', 'Talla creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('tallas')->with('error', $e->getMessage());
        }
    }
    
    public function edit($id){
        $talla = Talla::select('talla.id', 'talla.nombre')
        ->where('talla.id', $id)
        ->first();
        return view('talla.edit', ['talla' => $talla]);
    }
    
    public function update(Request $request){
        try {
            DB::beginTransaction();
            Talla::actualizar($request);
            DB::commit();
            return redirect()->to('tallas')->with('message', 'Talla actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('tallas')->with('error', $e->getMessage());
        }
    }
}
