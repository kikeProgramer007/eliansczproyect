<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Rol_permiso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index(){
        $clientes = Cliente::paginate(4);
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [28, 29, 30])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $editar = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 28){
                $crear = true;
            }
            if($item->idpermiso == 29){
                $listar = true;
            }
            if($item->idpermiso == 30){
                $editar = true;
            }
        }
        return view('cliente.index', ['clientes' => $clientes], compact('crear', 'listar', 'editar'));
    }

    public function busqueda(Request $request){
        try {
            $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [28, 29, 30])->where('condicion', 1)->get();
            $crear = false;
            $listar = false;
            $editar = false;
            foreach ($permisos_de_este_rol as $item) {
                if($item->idpermiso == 28){
                    $crear = true;
                }
                if($item->idpermiso == 29){
                    $listar = true;
                }
                if($item->idpermiso == 30){
                    $editar = true;
                }
            }
            if($request->input('opcion') == 'nombre'){
                $clientes = Cliente::select('cliente.id', 'cliente.nombre', 'cliente.telefono', 'cliente.correo')
                ->where('cliente.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(4);
                $view = view('cliente.datos', compact('clientes', 'crear', 'listar', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
            if($request->input('opcion') == 'telefono'){
                $clientes = Cliente::select('cliente.id', 'cliente.nombre', 'cliente.telefono', 'cliente.correo')
                ->where('cliente.telefono', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(4);

                $view = view('cliente.datos', compact('clientes', 'crear', 'listar', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function create(){
        $clientes = Cliente::where('id')->get();
        return view('cliente.create', ['clientes' => $clientes]);
    }
    
    public function store(Request $request){
        try {
            DB::beginTransaction();
            Cliente::store($request);
            DB::commit();
            return redirect()->to('clientes')->with('message', 'Cliente creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('clientes')->with('error', $e->getMessage());
        }
    }
    
    
    public function edit($id){
        $cliente = Cliente::select('cliente.id', 'cliente.nombre', 'cliente.telefono', 'cliente.correo')
        ->where('cliente.id', $id)
        ->first();
        return view('cliente.edit', ['cliente' => $cliente]);
    }
    
    public function update(Request $request){
        
        try {
            DB::beginTransaction();
            Cliente::actualizar($request);
            DB::commit();
            return redirect()->to('clientes')->with('message', 'Cliente actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('clientes')->with('error', $e->getMessage());
        }
    }
}
