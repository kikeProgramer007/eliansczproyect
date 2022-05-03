<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;
    protected $table = 'personal';
    protected $fillable = ['ci','nombre','sexo','telefono','direccion','condicion'];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('App\Models\User','idpersonal','id');
    }
}
