<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallenotasalida extends Model
{
    use HasFactory;
    protected $table = 'detallenotasalida';
    protected $fillable = ['precio', 'cantidad', 'total', 'idtallaproducto','idnotasalida'];
    public $timestamps = true;

    public function tallaproducto(){
        return $this->belongsTo('App\Models\Tallaproducto','idtallaproducto','id')->with('producto')->with('talla');
    }
    public function notasalida(){
        return $this->belongsTo('App\Models\Notasalida','idnotasalida','id');
    }
}
