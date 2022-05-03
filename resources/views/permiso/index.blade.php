@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <h4 class="text-primary" class="card-title">Permiso</h4>
                            </div>
                        </div>
                    </div>
                    @if ($listar)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <select class="form-control" id="opcion" name="opcion">
                                        <option class="text-dark" value="nombre">Nombre</option>
                                    </select>
                                </div>
                                <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            <div id="tabla">
                                @include('permiso.datos')
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function eliminar(permiso_id){
            Swal.fire({
                title: 'Estas seguro de eliminar el permiso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, elimínalo!',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('permiso/eliminar')}}",
                        data: {
                            id: permiso_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Eliminado!',
                                text: response.mensaje,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "/permisos";
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown ) {
                            console.log(jqXHR.responseJSON.mensaje);
                        }
                    });
                }
            });
        }

        jQuery(document).ready(function () {
            var page = 1;

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                paginar(page);
            });

            function paginar(page){
                var texto = $('#texto').val();
                var opcion = $('#opcion').val();
                $.ajax({
                    type: "GET",
                    url: "{{url('permiso/busqueda')}}" + '?page=' + page,
                    data: {
                        texto: texto,
                        opcion: opcion
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        // console.log(response);
                        $("#tabla").html(response.view);
                    },
                    error: function (jqXHR, textStatus, errorThrown ) {
                        console.log('ERROR');
                        console.log(jqXHR);
                    }
                });
            }

            $("#texto").keyup(function() {
                let texto = $("#texto").val();
                let opcion = $("#opcion").val();
                $.ajax({
                    type: "GET",
                    url: "{{url('permiso/busqueda')}}",
                    data: {
                        texto: texto,
                        opcion: opcion
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response);
                        $("#tabla").html(response.view);
                    },
                    error: function (jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            });
        });
    </script>
@endpush