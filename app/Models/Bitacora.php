<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $table = 'bitacora';
    protected $fillable = ['accion', 'tabla','nombre_implicado', 'idusuario', 'created_at', 'update_at'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\Models\User','idusuario','id')->with('personal');
    }
}
