<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary">
            <tr>
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Nombre</th>
                <th class="text-info" scope="col">Dirección</th>
                <th class="text-info" scope="col">Teléfono</th>
                <th class="text-info" scope="col">Email</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proveedores as $proveedor)
                <tr>
                    <td class="text-left">
                        @if ($editar)
                            <a type="button" title="Editar información del Proveedor" class="btn btn-primary btn-sm" href="{{url('proveedor/edit/'.$proveedor->id)}}">
                                <i class="tim-icons icon-pencil"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{$proveedor->nombre}}</td>
                    <td>{{$proveedor->direccion}}</td>
                    <td>{{$proveedor->telefono}}</td>
                    <td>{{$proveedor->correo}}</td>
                    <td>
                        <span class="badge badge-success">Activo</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$proveedores->links()}}
    </div>
</div>