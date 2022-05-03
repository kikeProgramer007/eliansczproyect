@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                <h4 class="text-primary" class="card-title">Roles</h4>
                            </div>
                            @if ($crear)
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-right">
                                    <a href="{{url('rol/create')}}" class="btn btn-sm btn-primary">Agregar</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($listar)
                    <div class="card-body">
                        @include('rol.datos')
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function desactivar(rol_id){
            Swal.fire({
                title: 'Estas seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivalo!',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('rol/desactivar')}}",
                        data: {
                            id: rol_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Desactivado!',
                                text: response.mensaje,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "/roles";
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

        function activar(rol_id){
            Swal.fire({
                title: 'Estas seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activalo!',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('rol/activar')}}",
                        data: {
                            id: rol_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Activado!',
                                text: response.mensaje,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "/roles";
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
0
        });
    </script>
@endpush