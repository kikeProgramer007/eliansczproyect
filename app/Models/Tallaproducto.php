<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Tallaproducto extends Model
{
    use HasFactory;
    protected $table = 'tallaproducto';
    protected $fillable = ['idproducto','idtalla','stock'];
    public $timestamps = true;

    public function producto(){
        return $this->belongsTo('App\Models\Producto','idproducto','id');
    }
    public function talla(){
        return $this->belongsTo('App\Models\Talla','idtalla','id');
    }

    public static function updateTallaProducto(Request $request){
        if(isset($request->tallas)){
            $tallas = $request->tallas;
            $tallas_sin_tiquear = Talla::whereNotIn('id', $tallas)->get();
            if($tallas){
                foreach ($tallas as $talla) {
                    $tallaproducto = Tallaproducto::where('idproducto', $request->idproducto)
                    ->where('idtalla', $talla)
                    ->first();
                    $tallaproducto->condicion = 1;
                    $tallaproducto->update();
                }
            }
            if($tallas_sin_tiquear){
                foreach ($tallas_sin_tiquear as $talla) {
                    $tallaproducto = Tallaproducto::where('idproducto', $request->idproducto)
                    ->where('idtalla', $talla->id)
                    ->first();
                    $tallaproducto->condicion = 0;
                    $tallaproducto->update();
                }
            }
        }else{
            $tallas_productos = Tallaproducto::where('idproducto', $request->idproducto)->get();
            foreach ($tallas_productos as $item) {
                $tallaproducto = Tallaproducto::find($item->id);
                $tallaproducto->condicion = 0;
                $tallaproducto->update();
            }
        }
    }

    public static function actualizar(Request $request){
        $tallaproducto = Tallaproducto::findOrFail($request->id);
        $tallaproducto->stock = $request->stock;
        $tallaproducto->update();
    }
    
}
