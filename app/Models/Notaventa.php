<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Notaventa extends Model
{
    use HasFactory;
    protected $table = 'notaventa';
    protected $fillable = ['monto_pago','descuento','monto_total','idusuario','idcliente','condicion','created_at'];
    public $timestamps = true;

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','idcliente','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','idusuario','id')->with('personal');
    }

    public static function store(Request $request){
        if(count(json_decode($request->detalles)) == 0){
            return "Es necesario ingresar algunos detalles";
        }
        $notaventa = new Notaventa();
        $notaventa->monto_pago = 0;
        $notaventa->descuento = $request->descuento;
        $notaventa->monto_total = 0;
        $notaventa->idcliente = $request->idcliente;
        $notaventa->idusuario = Auth::user()->id;
        $notaventa->save();
        // dd(json_decode($request->detalles));
        $total_de_detalles = 0;
        foreach (json_decode($request->detalles) as $detalle) {
            $obtener_tallaproducto_de_db = Tallaproducto::find($detalle->id);
            if($detalle->cantidad > $obtener_tallaproducto_de_db->stock){
                return "No hay suficiente stock del producto " . $obtener_tallaproducto_de_db->producto->nombre . " " . $obtener_tallaproducto_de_db->talla->nombre ;
            }

            $detallenotaventa = new Detallenotaventa();
            $detallenotaventa->precio = $detalle->precio;
            $detallenotaventa->cantidad = $detalle->cantidad;
            
            $obtener_tallaproducto_de_db->stock = $obtener_tallaproducto_de_db->stock - $detalle->cantidad;
            $obtener_tallaproducto_de_db->update();

            $productos = Producto::find($obtener_tallaproducto_de_db->idproducto); 

            $detallenotaventa->total = $detalle->total;
            $detallenotaventa->idtallaproducto = $detalle->id;
            $detallenotaventa->idnotaventa = $notaventa->id;
            $detallenotaventa->save();
            $total_de_detalles = $total_de_detalles + ($detalle->total - $detalle->total*$productos->oferta);
        }

        $notaventaactualizado = Notaventa::find($notaventa->id);
        $notaventaactualizado->monto_pago = $total_de_detalles;
        $notaventaactualizado->monto_total = $total_de_detalles - $notaventa->descuento;
        $notaventaactualizado->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Nota de venta';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();

        return '';
    }

}
