<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Notacompra extends Model
{
    use HasFactory;
    protected $table = 'notacompra';
    protected $fillable = ['monto_total', 'impuesto', 'idusuario','idproveedor','condicion','created_at'];
    public $timestamps = true;

    public function proveedor(){
        return $this->belongsTo('App\Models\Proveedor','idproveedor','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','idusuario','id')->with('personal');
    }

    public static function store(Request $request){
        if(count(json_decode($request->detalles)) == 0){
            return "Es necesario ingresar algunos detalles";
        }
        
        $notacompra = new Notacompra();
        $notacompra->monto_total = 0;
        $notacompra->impuesto = $request->impuesto;
        $notacompra->idproveedor = $request->idproveedor;
        $notacompra->idusuario = Auth::user()->id;
        $notacompra->save();
        // dd(json_decode($request->detalles));
        $total_de_detalles = 0;
        foreach (json_decode($request->detalles) as $detalle) {
            $obtener_tallaproducto_de_db = Tallaproducto::find($detalle->id);

            $detallenotacompra = new Detallenotacompra();
            $detallenotacompra->costo = $detalle->costo;
            $detallenotacompra->cantidad = $detalle->cantidad;
            
            $obtener_tallaproducto_de_db->stock = $obtener_tallaproducto_de_db->stock + $detalle->cantidad;
            $obtener_tallaproducto_de_db->update();

            $productos = Producto::find($obtener_tallaproducto_de_db->idproducto);
            $productos->costo = $detalle->costo;
            $productos->update();

            $detallenotacompra->importe = $detalle->importe;
            $detallenotacompra->idtallaproducto = $detalle->id;
            $detallenotacompra->idnotacompra = $notacompra->id;
            $detallenotacompra->save();
            $total_de_detalles = $total_de_detalles + $detalle->importe;
        }

        $notacompraactualizado = Notacompra::find($notacompra->id);
        $notacompraactualizado->monto_total = $total_de_detalles;
        $notacompraactualizado->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Nota de compra';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();

        return '';
    }
}
