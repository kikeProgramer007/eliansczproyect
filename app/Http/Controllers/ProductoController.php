<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Categoria;
use App\Models\Material;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Rol_permiso;
use App\Models\Talla;
use App\Models\Tallaproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(){
        $productos = Producto::join('categoria', 'producto.idcategoria', 'categoria.id')
        ->join('material', 'producto.idmaterial', 'material.id')
        ->join('marca', 'producto.idmarca', 'marca.id')
        ->select('producto.id', 'producto.nombre', 'producto.precio', 'producto.costo', 'producto.oferta', 'producto.descripcion', 'categoria.nombre as categoria_nombre', 'material.nombre as material_nombre', 'marca.nombre as marca_nombre', 'producto.condicion' , 'producto.imagen')
        ->paginate(3);

        // $users2 = User::with('rol')->with('personal')->get();
        // dd(json_decode(json_encode($users)),json_decode(json_encode($users2)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [13, 14, 15, 16, 17])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $cambiarEstado = false;
        $editar = false;
        $verStock = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 13){
                $crear = true;
            }
            if($item->idpermiso == 14){
                $listar = true;
            }
            if($item->idpermiso == 16){
                $cambiarEstado = true;
            }
            if($item->idpermiso == 15){
                $editar = true;
            }
            if($item->idpermiso == 17){
                $verStock = true;
            }
        }
        return view('producto.index', ['productos' => $productos] , compact('crear', 'listar', 'cambiarEstado', 'editar', 'verStock'));
    }

    public function create(){
        $categorias = Categoria::get();
        $materiales = Material::get();
        $marcas = Marca::get();
        return view('producto.create', ['categorias' => $categorias, 'materiales' => $materiales, 'marcas' => $marcas]);
    }

    public function busqueda(Request $request){
        try {
            $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [13, 14, 15, 16, 17])->where('condicion', 1)->get();
            $crear = false;
            $listar = false;
            $cambiarEstado = false;
            $editar = false;
            $verStock = false;
            foreach ($permisos_de_este_rol as $item) {
                if($item->idpermiso == 13){
                    $crear = true;
                }
                if($item->idpermiso == 14){
                    $listar = true;
                }
                if($item->idpermiso == 16){
                    $cambiarEstado = true;
                }
                if($item->idpermiso == 15){
                    $editar = true;
                }
                if($item->idpermiso == 17){
                    $verStock = true;
                }
            }
            if($request->input('opcion') == 'nombre'){
                $productos = Producto::join('categoria', 'producto.idcategoria', 'categoria.id')
                ->join('material', 'producto.idmaterial', 'material.id')
                ->join('marca', 'producto.idmarca', 'marca.id')
                ->select('producto.id', 'producto.nombre', 'producto.precio', 'producto.costo', 'producto.oferta', 'producto.descripcion', 'categoria.nombre as categoria_nombre', 'material.nombre as material_nombre', 'marca.nombre as marca_nombre', 'producto.condicion' , 'producto.imagen')
                ->where('producto.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(3);

                $view = view('producto.datos', compact('productos', 'crear', 'listar', 'cambiarEstado', 'editar', 'verStock'))->render();
                return response()->json(['view' => $view], 200);
            }
            if($request->input('opcion') == 'categoria'){
                $productos = Producto::join('categoria', 'producto.idcategoria', 'categoria.id')
                ->join('material', 'producto.idmaterial', 'material.id')
                ->join('marca', 'producto.idmarca', 'marca.id')
                ->select('producto.id', 'producto.nombre', 'producto.precio', 'producto.costo', 'producto.oferta', 'producto.descripcion', 'categoria.nombre as categoria_nombre', 'material.nombre as material_nombre', 'marca.nombre as marca_nombre', 'producto.condicion' , 'producto.imagen')
                ->where('categoria.nombre', 'LIKE', '%'.$request->input('texto').'%')
                ->paginate(3);
                
                $view = view('producto.datos', compact('productos', 'crear', 'listar', 'cambiarEstado', 'editar', 'verStock'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            Producto::store($request);
            DB::commit();
            return redirect()->to('productos')->with('message', 'Producto creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('productos')->with('error', $e->getMessage());
        }
    }
    

    public function edit($id){
        $producto = Producto::join('categoria', 'producto.idcategoria', 'categoria.id')
        ->join('material', 'producto.idmaterial', 'material.id')
        ->join('marca', 'producto.idmarca', 'marca.id')
        ->select('producto.id', 'producto.nombre', 'producto.precio', 'producto.costo', 'producto.oferta', 'producto.descripcion', 'producto.idcategoria', 'categoria.nombre as categoria_nombre', 'producto.idmaterial', 'material.nombre as material_nombre', 'producto.idmarca', 'marca.nombre as marca_nombre')
        ->where('producto.id', $id)
        ->first();
        $categorias = Categoria::get();
        $materiales = Material::get();
        $marcas = Marca::get();
        return view('producto.edit', ['producto' => $producto, 'categorias' => $categorias, 'materiales' => $materiales, 'marcas' => $marcas]);
    }

    public function ver($idproducto){
        $tallaproductos = Tallaproducto::join('producto', 'tallaproducto.idproducto', 'producto.id')
        ->join('talla', 'tallaproducto.idtalla', 'talla.id')
        ->select('tallaproducto.id','tallaproducto.idtalla', 'talla.nombre as talla_nombre', 'tallaproducto.stock')
        ->where('tallaproducto.idproducto', $idproducto)
        ->where('tallaproducto.condicion', 1)
        ->get();

        $producto = Producto::find($idproducto);
        $tallas = Talla::get();
        return view('producto.indextp', ['tallaproductos' => $tallaproductos, 'producto' => $producto, 'tallas' => $tallas]);
    }

    public function update(Request $request){
        
        try {
            DB::beginTransaction();
            Producto::actualizar($request);
            DB::commit();
            return redirect()->to('productos')->with('message', 'Producto actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('productos')->with('error', $e->getMessage());
        }
    }

    public function desactivar(Request $request){
        try {
            DB::beginTransaction();
            $producto = Producto::findOrFail($request->input('id'));
            $producto->condicion = 0;
            $producto->update();

            $tallasproductos = Tallaproducto::where('idproducto', $producto->id)->get();
            foreach ($tallasproductos as $value) {
                $tallaproducto = Tallaproducto::find($value->id);
                $tallaproducto->condicion = 0;
                $tallaproducto->update();
            }

            $bitacora = new Bitacora();
            $bitacora->accion = 'Desactivar';
            $bitacora->tabla = 'Producto';
            $bitacora->nombre_implicado = $producto->nombre;
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();
            DB::commit();
            return  response()->json(['mensaje' => 'Producto desactivado...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function activar(Request $request){
        try {
            DB::beginTransaction();
            $producto = Producto::findOrFail($request->input('id'));
            $producto->condicion = 1;
            $producto->update();

            $tallasproductos = Tallaproducto::where('idproducto', $producto->id)->get();
            foreach ($tallasproductos as $value) {
                $tallaproducto = Tallaproducto::find($value->id);
                $tallaproducto->condicion = 1;
                $tallaproducto->update();
            }

            $bitacora = new Bitacora();
            $bitacora->accion = 'Activar';
            $bitacora->tabla = 'Producto';
            $bitacora->nombre_implicado = $producto->nombre;
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();
            DB::commit();
            return  response()->json(['mensaje' => 'Producto activado...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function updateTallaProducto(Request $request){ //lapiz de ver talla producto
        try {
            DB::beginTransaction();
            Tallaproducto::updateTallaProducto($request);
            DB::commit();
            return redirect()->to('producto/ver/'.$request->idproducto)->with('message', 'Talla Producto actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->to('producto/ver/'.$request->idproducto)->with('error', $e->getMessage());
        }
    }
}
