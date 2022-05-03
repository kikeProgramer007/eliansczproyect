<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Talla extends Model
{
    use HasFactory;
    protected $table = 'talla';
    protected $fillable = ['nombre'];
    public $timestamps = false;

    public function tallaproducto()
    {
        return $this->hasMany('App\Models\Tallaproducto','idtalla','id');
    }

    public static function store(Request $request){
        $talla = new Talla();
        $talla->nombre = $request->nombre;
        $talla->save();

        $productos = Producto::where('condicion', 1)->get();
        foreach ($productos as $producto) {
            $tallaproducto = new Tallaproducto(); 
            $tallaproducto->idtalla = $talla->id;
            $tallaproducto->idproducto = $producto->id;
            $tallaproducto->stock = 0;
            $tallaproducto->save();
        }

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Talla';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $talla = Talla::findOrFail($request->id);
        $talla->nombre = $request->nombre;
        $talla->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Talla';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
