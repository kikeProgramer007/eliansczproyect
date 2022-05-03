@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                                <a href="{{url('notascompras/')}}">
                                    <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                        <i class="fas fa-arrow-left"></i>Atras
                                    </button>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <div style="display:table; text-align: center;">
                                    <h4 class="text-primary" style="display:table-cell; vertical-align:middle;">Creando Nueva Nota de Compra</h4>
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form_notacompra" action="{{url('notacompra/store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="detalles" id="detalles_input">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="text-info">Seleccione el o los productos: </label>
                                    <select class="form-control" id="idtallaproducto" name="idtallaproducto">
                                        <option value="vacio" disabled selected>Seleccione...</option>
                                        @foreach ($tallasproductos as $item)
                                            <option class="text-dark" value="{{$item->id}}">{{$item->producto->nombre}} {{$item->talla->nombre}}-{{$item->stock}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-info">Seleccione al proveedor: </label>
                                    <select class="form-control" required id="idproveedor" name="idproveedor">
                                        @foreach ($proveedores as $item)
                                            <option class="text-dark" value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-info">Impuesto: </label>
                                    <div class="input-group">
                                        <input name="impuesto" class="form-control" min="0" type="number" value="0" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Costo</th>
                                                    <th>Cantidad</th>
                                                    <th>Importe</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detalles">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row"  style="padding-right: 15px;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" onclick="tratardeagregarnotacompra()" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    let detalles = [];
    var tallasproductos = {!! json_encode($tallasproductos) !!};

    function actualizarCantidad(id){
        var elemento = document.getElementById(`cantidad-${id}`);

        detalles.forEach(element => {
            if(element.id == id){
                element.cantidad = elemento.value;
                element.importe =  element.cantidad * element.costo;
            }
        });

        $('#detalles').html('');
        detalles.forEach(element => {
            $('#detalles').append(`
                <tr>
                    <td>`+(element.nombre)+`</td>
                    <td><input class="form-control" type="text" id="costo-`+(element.id)+`" onchange="actualizarCosto('`+element.id+`')" value="`+(element.costo)+`" required></td>
                    <td><input class="form-control" type="text" id="cantidad-`+(element.id)+`" onchange="actualizarCantidad('`+element.id+`')" value="`+(element.cantidad)+`" required></td>
                    <td>`+(element.importe)+`</td>
                    <td>
                        <button type="button" onclick="eliminarDetalle(`+(element.id)+`)" class="btn btn-danger btn-sm">
                            <i class="tim-icons icon-trash-simple"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    function actualizarCosto(id){
        var elemento = document.getElementById(`costo-${id}`);

        detalles.forEach(element => {
            if(element.id == id){
                element.costo = elemento.value;
                element.importe =  element.cantidad * element.costo;
            }
        });

        $('#detalles').html('');
        detalles.forEach(element => {
            $('#detalles').append(`
                <tr>
                    <td>`+(element.nombre)+`</td>
                    <td><input class="form-control" type="text" id="costo-`+(element.id)+`" onchange="actualizarCosto('`+element.id+`')" value="`+(element.costo)+`" required></td>
                    <td><input class="form-control" type="text" id="cantidad-`+(element.id)+`" onchange="actualizarCantidad('`+element.id+`')" value="`+(element.cantidad)+`" required></td>
                    <td>`+(element.importe)+`</td>
                    <td>
                        <button type="button" onclick="eliminarDetalle(`+(element.id)+`)" class="btn btn-danger btn-sm">
                            <i class="tim-icons icon-trash-simple"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    function eliminarDetalle(id){
        detalles.forEach(function(element, index, object) {
            if(element.id == id){
                object.splice(index, 1);
            }
        });

        $('#detalles').html('');
        detalles.forEach(element => {
            $('#detalles').append(`
                <tr>
                    <td>`+(element.nombre)+`</td>
                    <td><input class="form-control" type="text" id="costo-`+(element.id)+`" onchange="actualizarCosto('`+element.id+`')" value="`+(element.costo)+`" required></td>
                    <td><input class="form-control" type="text" id="cantidad-`+(element.id)+`" onchange="actualizarCantidad('`+element.id+`')" value="`+(element.cantidad)+`" required></td>
                    <td>`+(element.importe)+`</td>
                    <td>
                        <button type="button" onclick="eliminarDetalle(`+(element.id)+`)" class="btn btn-danger btn-sm">
                            <i class="tim-icons icon-trash-simple"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    function tratardeagregarnotacompra(){
        $('#detalles_input').val(JSON.stringify(detalles));
        console.log($('#detalles_input').val());
        console.log(detalles);
        var form_notacompra = document.getElementById('form_notacompra');
        console.log(form_notacompra);
        if (form_notacompra.checkValidity()) {
            $.ajax({
                type: "POST",
                url: "{{url('notacompra/store')}}",
                data: new FormData($("#form_notacompra")[0]),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'JSON',
                async: true,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log(response);
                    Swal.fire({
                        title: 'Agregado!',
                        text: response.mensaje,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "/notascompras";
                        }
                    });
                    
                },
                error: function (jqXHR, textStatus, errorThrown ) {
                    // console.log(jqXHR);
                    // console.log(textStatus);
                    // console.log(errorThrown );
                    Swal.fire({
                        title: 'Oops...',
                        text: jqXHR.responseJSON.mensaje,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            
                        }
                    });
                }
            });
        }else{
            form_notacompra.reportValidity();
        }
    }

    $(document).ready(function () {
        $('#idtallaproducto').on('change', function() {
            // console.log(this.value);
            tallasproductos.forEach(element => {
                if(this.value == element.id){
                    let detalle = {id: element.id, nombre: element.producto.nombre + ' ' + element.talla.nombre, costo: 0, cantidad: 1, importe: 0};
                    
                    var bandera = false;
                    detalles.forEach(element => {
                        if(element.id == this.value){
                            bandera = true;
                            element.cantidad++;
                            element.importe =  element.cantidad * element.costo;
                        }
                    });
                    if(!bandera){
                        detalles.push(detalle);
                    }
                    
                    $('#detalles').html('');
                    detalles.forEach(element => {
                        $('#detalles').append(`
                            <tr>
                                <td>`+(element.nombre)+`</td>
                                <td><input class="form-control" type="text" id="costo-`+(element.id)+`" onchange="actualizarCosto('`+element.id+`')" value="`+(element.costo)+`" required></td>
                                <td><input class="form-control" type="text" id="cantidad-`+(element.id)+`" onchange="actualizarCantidad('`+element.id+`')" value="`+(element.cantidad)+`" required></td>
                                <td>`+(element.importe)+`</td>
                                <td>
                                    <button type="button" onclick="eliminarDetalle(`+(element.id)+`)" class="btn btn-danger btn-sm">
                                        <i class="tim-icons icon-trash-simple"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                    
                }
            });
        });
    });
</script>
@endpush