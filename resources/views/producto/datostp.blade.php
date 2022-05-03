<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr>
                <th class="text-info" scope="col">Talla</th>
                <th class="text-info" scope="col">Stock</th>
                <th class="text-info" scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tallaproductos as $tallaproducto)
                <tr>
                    <td>{{$tallaproducto->talla_nombre}}</td>
                    <td>
                        @if ($tallaproducto->stock > 10)
                            <span class="badge badge-success">{{$tallaproducto->stock}}</span>
                        @else
                            <span class="badge badge-danger">{{$tallaproducto->stock}}</span>
                        @endif
                    </td>
                    <td>
                        <a type="button" title="Editar stock del Producto" class="btn btn-primary btn-sm" href="{{url('tallaproducto/ver/'.$tallaproducto->id)}}">
                            <i class="tim-icons icon-pencil"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>