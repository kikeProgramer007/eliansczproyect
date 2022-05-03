<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr>
                <th class="text-info" scope="col">Producto</th>
                <th class="text-info" scope="col">Precio</th>
                <th class="text-info" scope="col">Cantidad</th>
                <th class="text-info" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detallesnotasventas as $detallenotaventa)
                <tr>
                    <td>{{$detallenotaventa->tallaproducto->producto->nombre}} {{$detallenotaventa->tallaproducto->talla->nombre}}</td>
                    <td>{{$detallenotaventa->precio}}</td>
                    <td>{{$detallenotaventa->cantidad}}</td>
                    <td>{{$detallenotaventa->total}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>