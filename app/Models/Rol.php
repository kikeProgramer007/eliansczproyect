<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'rol';
    protected $fillable = ['nombre','condicion'];
    public $timestamps = false;

    public function user()
    {
        return $this->hasMany('App\Models\User','idrol','id');
    }

    public function rol_permiso()
    {
        return $this->hasMany('App\Models\Rol_permiso','idrol','id');
    }

    public static function store(Request $request){
        $rol = new Rol();
        $rol->nombre = $request->nombre;
        $rol->save();

        $permisos = Permiso::get();
        foreach ($permisos as $permiso) {
            $rol_permiso = new Rol_permiso(); 
            $rol_permiso->idpermiso = $permiso->id;
            $rol_permiso->idrol = $rol->id;
            $rol_permiso->save();
        }

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Rol';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $rol = Rol::findOrFail($request->id);
        $rol->nombre = $request->nombre;
        $rol->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Rol';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
