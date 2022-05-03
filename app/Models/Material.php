<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Material extends Model
{
    use HasFactory;
    protected $table = 'material';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public function producto()
    {
        return $this->hasMany('App\Models\Producto','idmaterial','id');
    }

    public static function store(Request $request){
        $material = new Material();
        $material->nombre = $request->nombre;
        $material->save();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Material';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $material = Material::findOrFail($request->id);
        $material->nombre = $request->nombre;
        $material->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Material';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
