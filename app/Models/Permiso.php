<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permiso extends Model
{
    use HasFactory;
    protected $table = 'permiso';
    protected $fillable = ['nombre','condicion'];
    public $timestamps = false;

    public function rol_permiso()
    {
        return $this->hasMany('App\Models\Rol_permiso','idpermiso','id');
    }

    public static function actualizar(Request $request){
        $permiso = Permiso::findOrFail($request->id);
        $permiso->nombre = $request->nombre;
        $permiso->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Permiso';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
