<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = ['nombre','telefono','correo'];
    public $timestamps = false;

    public function notaventa()
    {
        return $this->hasMany('App\Models\Notaventa','idcliente','id');
    }

    public static function store(Request $request){
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Cliente';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $cliente = Cliente::findOrFail($request->id);
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Cliente';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
