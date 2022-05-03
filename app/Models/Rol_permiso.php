<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Rol_permiso extends Model
{
    use HasFactory;
    protected $table = 'rol_permiso';
    protected $fillable = ['idrol','idpermiso','condicion'];
    public $timestamps = false;

    public function permiso(){
        return $this->belongsTo('App\Models\Permiso','idpermiso','id');
    }
    public function rol(){
        return $this->belongsTo('App\Models\Rol','idrol','id');
    }

    public static function updateRolpermiso(Request $request){
        // dd(json_decode(json_encode($request->all())));
        if(isset($request->permisos)){
            $permisos = $request->permisos;
            $permisos_sin_tiquear = Permiso::whereNotIn('id', $permisos)->get();
            if($permisos){
                foreach ($permisos as $permiso) {
                    $rol_permiso = Rol_permiso::where('idrol', $request->idrol)
                    ->where('idpermiso', $permiso)
                    ->first();
                    $rol_permiso->condicion = 1;
                    $rol_permiso->update();
                }
            }
            if($permisos_sin_tiquear){
                foreach ($permisos_sin_tiquear as $permiso) {
                    $rol_permiso = Rol_permiso::where('idrol', $request->idrol)
                    ->where('idpermiso', $permiso->id)
                    ->first();
                    $rol_permiso->condicion = 0;
                    $rol_permiso->update();
                }
            }
        }else{
            $roles_permisos = Rol_permiso::where('idrol', $request->idrol)->get();
            foreach ($roles_permisos as $item) {
                $rol_permiso = Rol_permiso::find($item->id);
                $rol_permiso->condicion = 0;
                $rol_permiso->update();
            }
        }
    }
}
