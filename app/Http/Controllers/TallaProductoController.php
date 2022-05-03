<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tallaproducto;
use Illuminate\Support\Facades\DB;

class TallaProductoController extends Controller
{
    public function ver($id){
        $tallaproducto = Tallaproducto::findOrFail($id);
        
        return view('producto.ver', ['tallaproducto' => $tallaproducto]);
    }

    public function update(Request $request){
        try {
            DB::beginTransaction();
            Tallaproducto::actualizar($request);
            DB::commit();
            return redirect()->to('productos')->with('message', 'Stock actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('productos')->with('error', $e->getMessage());
        }
    }
}
