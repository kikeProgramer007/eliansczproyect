<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr >
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Nombre</th>
                <th class="text-info" scope="col">Precio</th>
                <th class="text-info" scope="col">Costo</th>
                <th class="text-info" scope="col">Oferta</th>
                <th class="text-info" scope="col">Categoria</th>
                <th class="text-info" scope="col">Material</th>
                <th class="text-info" scope="col">Marca</th>
                <th class="text-info" scope="col">Imagen</th>
                <th class="text-info" scope="col">Descripcion</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td class="text-left">
                        @if ($cambiarEstado)
                            @if ($producto->condicion == 1)
                                <button type="button" title="Deshabilitar Producto" class="btn btn-danger btn-sm" onclick="desactivar({{$producto->id}})">
                                    <i class="tim-icons icon-trash-simple"></i>
                                </button>
                            @else
                                <button type="button" title="Habilitar Producto" class="btn btn-info btn-sm" onclick="activar({{$producto->id}})">
                                    <i class="tim-icons icon-check-2"></i>
                                </button>
                            @endif
                        @endif
                        @if ($editar)
                            <a type="button" title="Editar información del Producto" class="btn btn-primary btn-sm" href="{{url('producto/edit/'.$producto->id)}}">
                                <i class="tim-icons icon-pencil"></i>
                            </a>
                        @endif
                        @if ($verStock)
                        <a type="button" title="Ver stock del Producto" class="btn btn-success btn-sm" href="{{url('producto/ver/'.$producto->id)}}">
                            <i class="tim-icons icon-tap-02"></i>
                        </a>
                        @endif
                    </td>
                    <td>{{$producto->nombre}}</td>
                    <td>{{$producto->precio}}</td>
                    <td>{{$producto->costo}}</td>
                    <td>{{$producto->oferta}}</td>
                    <td>{{$producto->categoria_nombre}}</td>
                    <td>{{$producto->material_nombre}}</td>
                    <td>{{$producto->marca_nombre}}</td>
                    <td>
                        @if ($producto->imagen)
                            <img src="{{asset('storage/'.$producto->imagen)}}" style="border-radius: 40px; height: 80px; width: 80px">
                        @else
                            No hay imagen
                        @endif
                    </td>
                    <td>{{$producto->descripcion}}</td>
                    <td>
                        @if ($producto->condicion == 1)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$productos->links()}}
    </div>
</div>