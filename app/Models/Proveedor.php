<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedor';
    protected $fillable = ['nombre', 'direccion', 'telefono','correo'];
    public $timestamps = true;

    public function notacompra()
    {
         return $this->hasMany('App\Models\Notacompra','idproveedor','id');
    }

    public static function store(Request $request){
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo = $request->correo;
        $proveedor->save();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Proveedor';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->nombre = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo = $request->correo;
        $proveedor->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Proveedor';
        $bitacora->nombre_implicado = $request->nombre;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
