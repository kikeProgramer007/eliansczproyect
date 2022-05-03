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
            @foreach ($detallesnotassalidas as $detallenotasalida)
                <tr>
                    <td>{{$detallenotasalida->tallaproducto->producto->nombre}} {{$detallenotasalida->tallaproducto->talla->nombre}}</td>
                    <td>{{$detallenotasalida->precio}}</td>
                    <td>{{$detallenotasalida->cantidad}}</td>
                    <td>{{$detallenotasalida->total}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>