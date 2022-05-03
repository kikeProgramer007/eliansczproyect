<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marca';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public function producto()
    {
        return $this->hasMany('App\Models\Producto','idmarca','id');
    }

    public static function store(Request $request){
        $marca = new Marca();
        $marca->nombre = $request->nombre;
        $marca->save();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Marca';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $marca = Marca::findOrFail($request->id);
        $marca->nombre = $request->nombre;
        $marca->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Marca';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
