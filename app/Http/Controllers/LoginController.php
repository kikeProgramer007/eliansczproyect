<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bitacora;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'condicion' => 1])) {
            $request->session()->regenerate();

            $bitacora = new Bitacora();
            $bitacora->accion = 'Inició Sesión';
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();

            if (Auth::user()->idrol == 1){
                return redirect()->intended('dashboard');
            }else{
                return redirect()->intended('dashboard2');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request){
        $bitacora = new Bitacora();
        $bitacora->accion = 'Salió Sesión';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function olvidar_contraseña(){
        return view('olvidar_contraseña');
    }

    public function nueva_contraseña(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user)
        {
            $user->password = Hash::make($request->password);
            $user->update();
            return redirect('/');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function editar_perfil($idusuario){
        $user = User::join('personal', 'users.idpersonal', 'personal.id')
        ->join('rol', 'users.idrol', 'rol.id')
        ->select('users.id', 'users.email', 'personal.ci', 'personal.nombre', 'personal.sexo', 'personal.telefono', 'personal.direccion', 'users.idrol', 'rol.nombre as rol_nombre', 'users.imagen')
        ->where('users.id', $idusuario)
        ->first();
        $roles = Rol::where('condicion', 1)->get();
        return view('perfil', ['user' => $user, 'roles' => $roles]);
    }
}
