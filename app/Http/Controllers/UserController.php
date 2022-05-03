<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Personal;
use App\Models\Rol;
use App\Models\Rol_permiso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users = User::join('personal', 'users.idpersonal', 'personal.id')
        ->join('rol', 'users.idrol', 'rol.id')
        ->select('users.id', 'users.email', 'personal.ci', 'personal.nombre', 'personal.sexo', 'personal.telefono', 'personal.direccion', 'rol.nombre as rol_nombre', 'users.condicion' , 'users.imagen')
        ->paginate(2);

        // $users2 = User::with('rol')->with('personal')->get();
        // dd(json_decode(json_encode($users)),json_decode(json_encode($users2)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [54, 55, 56, 57])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $cambiarEstado = false;
        $editar = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 54){
                $crear = true;
            }
            if($item->idpermiso == 55){
                $listar = true;
            }
            if($item->idpermiso == 56){
                $cambiarEstado = true;
            }
            if($item->idpermiso == 57){
                $editar = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('user.index', ['users' => $users], compact('crear', 'listar', 'cambiarEstado', 'editar'));
    }

    public function busqueda(Request $request){
        try {
            $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [54, 55, 56, 57])->where('condicion', 1)->get();
            $crear = false;
            $listar = false;
            $cambiarEstado = false;
            $editar = false;
            foreach ($permisos_de_este_rol as $item) {
                if($item->idpermiso == 54){
                    $crear = true;
                }
                if($item->idpermiso == 55){
                    $listar = true;
                }
                if($item->idpermiso == 56){
                    $cambiarEstado = true;
                }
                if($item->idpermiso == 57){
                    $editar = true;
                }
            }
            if($request->input('opcion') == 'nombre'){
                $users = User::join('personal', 'users.idpersonal', 'personal.id')
                ->join('rol', 'users.idrol', 'rol.id')
                ->select('users.id', 'users.email', 'personal.ci', 'personal.nombre', 'personal.sexo', 'personal.telefono', 'personal.direccion', 'rol.nombre as rol_nombre', 'users.condicion', 'users.imagen')
                ->where('personal.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(2);

                $view = view('user.datos', compact('users', 'crear', 'listar', 'cambiarEstado', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
            if($request->input('opcion') == 'telefono'){
                $users = User::join('personal', 'users.idpersonal', 'personal.id')
                ->join('rol', 'users.idrol', 'rol.id')
                ->select('users.id', 'users.email', 'personal.ci', 'personal.nombre', 'personal.sexo', 'personal.telefono', 'personal.direccion', 'rol.nombre as rol_nombre', 'users.condicion', 'users.imagen')
                ->where('personal.telefono', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(2);

                $view = view('user.datos', compact('users', 'crear', 'listar', 'cambiarEstado', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
            if($request->input('opcion') == 'direccion'){
                $users = User::join('personal', 'users.idpersonal', 'personal.id')
                ->join('rol', 'users.idrol', 'rol.id')
                ->select('users.id', 'users.email', 'personal.ci', 'personal.nombre', 'personal.sexo', 'personal.telefono', 'personal.direccion', 'rol.nombre as rol_nombre', 'users.condicion', 'users.imagen')
                ->where('personal.direccion', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(2);
                
                $view = view('user.datos', compact('users', 'crear', 'listar', 'cambiarEstado', 'editar'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function create(){
        $roles = Rol::where('condicion', 1)->get();
        return view('user.create', ['roles' => $roles]);
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            User::store($request);
            DB::commit();
            return redirect()->to('users')->with('message', 'Usuario creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('users')->with('error', $e->getMessage());
        }
    }
    

    public function edit($id){
        $user = User::join('personal', 'users.idpersonal', 'personal.id')
        ->join('rol', 'users.idrol', 'rol.id')
        ->select('users.id', 'users.email', 'personal.ci', 'personal.nombre', 'personal.sexo', 'personal.telefono', 'personal.direccion', 'users.idrol', 'rol.nombre as rol_nombre')
        ->where('users.id', $id)
        ->first();
        $roles = Rol::where('condicion', 1)->get();
        return view('user.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request){
        
        try {
            DB::beginTransaction();
            User::actualizar($request);
            DB::commit();
            return redirect()->to('users')->with('message', 'Usuario actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('users')->with('error', $e->getMessage());
        }
    }

    public function updateperfil(Request $request){
        
        try {
            DB::beginTransaction();
            User::actualizar($request);
            DB::commit();
            if (Auth::user()->idrol == 1){
                return redirect()->to('dashboard')->with('message', 'Perfil actualizado exitosamente');
            }else{
                return redirect()->to('dashboard2')->with('message', 'Perfil actualizado exitosamente');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('users')->with('error', $e->getMessage());
        }
    }

    public function desactivar(Request $request){
        try {
            DB::beginTransaction();
            $user = User::findOrFail($request->input('id'));
            $user->condicion = 0;
            $user->update();

            $personal = Personal::findOrFail($user->idpersonal);

            $bitacora = new Bitacora();
            $bitacora->accion = 'Desactivar';
            $bitacora->tabla = 'Usuario';
            $bitacora->nombre_implicado = $personal->nombre;
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();

            DB::commit();
            return  response()->json(['mensaje' => 'Usuario desactivado...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function activar(Request $request){
        try {
            DB::beginTransaction();
            $user = User::findOrFail($request->input('id'));
            $user->condicion = 1;
            $user->update();

            $personal = Personal::findOrFail($user->idpersonal);

            $bitacora = new Bitacora();
            $bitacora->accion = 'Activar';
            $bitacora->tabla = 'Usuario';
            $bitacora->nombre_implicado = $personal->nombre;
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();

            DB::commit();
            return  response()->json(['mensaje' => 'Usuario activado...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }
}
