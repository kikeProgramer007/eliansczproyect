<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr>
                <th class="text-info" scope="col">Permiso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles_permisos as $rol_permiso)
                <tr>
                    <td>{{$rol_permiso->permiso_nombre}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>