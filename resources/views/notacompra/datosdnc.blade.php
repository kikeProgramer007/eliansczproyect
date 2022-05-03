<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr>
                <th class="text-info" scope="col">Producto</th>
                <th class="text-info" scope="col">Costo</th>
                <th class="text-info" scope="col">Cantidad</th>
                <th class="text-info" scope="col">Importe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detallesnotascompras as $detallenotacompra)
                <tr>
                    <td>{{$detallenotacompra->tallaproducto->producto->nombre}} {{$detallenotacompra->tallaproducto->talla->nombre}}</td>
                    <td>{{$detallenotacompra->costo}}</td>
                    <td>{{$detallenotacompra->cantidad}}</td>
                    <td>{{$detallenotacompra->importe}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>