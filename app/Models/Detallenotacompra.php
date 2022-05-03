<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallenotacompra extends Model
{
    use HasFactory;
    protected $table = 'detallenotacompra';
    protected $fillable = ['costo','cantidad','importe', 'idtallaproducto','idnotacompra'];
    public $timestamps = true;

    public function tallaproducto(){
        return $this->belongsTo('App\Models\Tallaproducto','idtallaproducto','id')->with('producto')->with('talla');
    }
    public function notacompra(){
        return $this->belongsTo('App\Models\Notacompra','idnotacompra','id');
    }
}
