<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Notasalida extends Model
{
    use HasFactory;
    protected $table = 'notasalida';
    protected $fillable = ['perdida_total', 'descripcion','condicion','created_at', 'idusuario'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\Models\User','idusuario','id')->with('personal');
    }

    public static function store(Request $request){
        if(count(json_decode($request->detalles)) == 0){
            return "Es necesario ingresar algunos detalles";
        }
        $notasalida = new Notasalida();
        $notasalida->perdida_total = 0;
        $notasalida->descripcion = $request->descripcion;
        $notasalida->idusuario = Auth::user()->id;
        $notasalida->save();
        // dd(json_decode($request->detalles));
        $total_de_detalles = 0;
        foreach (json_decode($request->detalles) as $detalle) {
            $obtener_tallaproducto_de_db = Tallaproducto::find($detalle->id);
            if($detalle->cantidad > $obtener_tallaproducto_de_db->stock){
                return "No hay suficiente stock del producto " . $obtener_tallaproducto_de_db->producto->nombre . " " . $obtener_tallaproducto_de_db->talla->nombre ;
            }

            $detallenotasalida = new Detallenotasalida();
            $detallenotasalida->precio = $detalle->precio;
            $detallenotasalida->cantidad = $detalle->cantidad;
            
            $obtener_tallaproducto_de_db->stock = $obtener_tallaproducto_de_db->stock - $detalle->cantidad;
            $obtener_tallaproducto_de_db->update();

            $productos = Producto::find($obtener_tallaproducto_de_db->idproducto); 

            $detallenotasalida->total = $detalle->total;
            $detallenotasalida->idtallaproducto = $detalle->id;
            $detallenotasalida->idnotasalida = $notasalida->id;
            $detallenotasalida->save();
            $total_de_detalles = $total_de_detalles + ($detalle->total - $detalle->total*$productos->oferta);
        }

        $notasalidaactualizado = Notasalida::find($notasalida->id);
        $notasalidaactualizado->perdida_total = $total_de_detalles;
        $notasalidaactualizado->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Nota de salida';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();

        return '';
    }
}
