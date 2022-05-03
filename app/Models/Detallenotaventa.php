<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallenotaventa extends Model
{
    use HasFactory;
    protected $table = 'detallenotaventa';
    protected $fillable = ['precio','cantidad','total', 'idtallaproducto','idnotaventa'];
    public $timestamps = true;

    public function tallaproducto(){
        return $this->belongsTo('App\Models\Tallaproducto','idtallaproducto','id')->with('producto')->with('talla');
    }
    public function notaventa(){
        return $this->belongsTo('App\Models\Notaventa','idnotaventa','id');
    }

    
}
