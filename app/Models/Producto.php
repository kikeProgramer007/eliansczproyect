<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = ['nombre','precio','costo','oferta','imagen','idcategoria','idmaterial','idmarca','descripcion','condicion'];
    public $timestamps = true;

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria','idcategoria','id');
    }

    public function material(){
        return $this->belongsTo('App\Models\Material','idmaterial','id');
    }

    public function marca(){
        return $this->belongsTo('App\Models\Marca','idmarca','id');
    }

    public function tallaproductos()
    {
        return $this->hasMany('App\Models\Tallaproducto','idproducto','id');
    }

    public static function store(Request $request){
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->costo = $request->costo;
        $producto->oferta = $request->oferta;
        if($request->hasFile('imagen')){
            $extension = $request->imagen->extension();
            if($extension == "png" || $extension == "jpg" || $extension == "jpeg"){
                $nombre = round(microtime(true)) . '.' . $extension;
                Storage::disk('public')->putFileAs('productos', $request->imagen, $nombre);
                $path = 'productos/' . $nombre;
                $producto->imagen = $path;
            }
        }
        $producto->descripcion = $request->descripcion;
        $producto->idcategoria = $request->idcategoria;
        $producto->idmaterial = $request->idmaterial;
        $producto->idmarca = $request->idmarca;
        $producto->save();

        $tallas = Talla::get();
        foreach ($tallas as $talla) {
            $tallaproducto = new Tallaproducto(); 
            $tallaproducto->idtalla = $talla->id;
            $tallaproducto->idproducto = $producto->id;
            $tallaproducto->stock = 0;
            $tallaproducto->save();
        }

        $bitacora = new Bitacora();
        $bitacora->accion = 'Registrar';
        $bitacora->tabla = 'Producto';
        $bitacora->nombre_implicado = $request->nombre;;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }

    public static function actualizar(Request $request){
        $producto = Producto::findOrFail($request->id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->costo = $request->costo;
        $producto->oferta = $request->oferta;
        if($request->hasFile('imagen')){
            if($producto->imagen){
                Storage::disk('public')->delete($producto->imagen);
            }
            $extension = $request->imagen->extension();
            if($extension == "png" || $extension == "jpg" || $extension == "jpeg"){
                $nombre = round(microtime(true)) . '.' . $extension;
                Storage::disk('public')->putFileAs('productos', $request->imagen, $nombre);
                $path = 'productos/' . $nombre;
                $producto->imagen = $path;
            }
        }
        $producto->descripcion = $request->descripcion;
        $producto->idcategoria = $request->idcategoria;
        $producto->idmaterial = $request->idmaterial;
        $producto->idmarca = $request->idmarca;
        $producto->update();

        $bitacora = new Bitacora();
        $bitacora->accion = 'Actualizar';
        $bitacora->tabla = 'Producto';
        $bitacora->nombre_implicado = $request->nombre;;
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();
    }
}
