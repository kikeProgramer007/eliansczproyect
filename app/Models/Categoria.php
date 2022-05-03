<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categoria';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public function producto()
    {
        return $this->hasMany('App\Models\Producto','idcategoria','id');
    }

    public static function store(Request $request){
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Categoria';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Categoria';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
