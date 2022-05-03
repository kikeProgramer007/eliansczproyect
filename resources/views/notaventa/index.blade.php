@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                <h4 class="text-primary" class="card-title">Nota de Venta</h4>
                            </div>
                            @if ($crear)
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-right">
                                    <a href="{{url('notaventa/create')}}" class="btn btn-sm btn-primary">Agregar</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($listar)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <input type="date" id="desde" name="desde" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                                </div>
                                <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <input type="date" id="hasta" name="hasta" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <select class="form-control" id="opcion" name="opcion">
                                        <option class="text-dark" value="cliente">Cliente</option>
                                    </select>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            <div id="tabla">
                                @include('notaventa.datos')
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
        function desactivar(notaventa_id){
            Swal.fire({
                title: 'Estas seguro de eliminar la nota?',
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
                        url: "{{url('notaventa/desactivar')}}",
                        data: {
                            id: notaventa_id
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
                                    window.location = "/notasventas";
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
                let desde= $('#desde').val();
                let hasta= $('#hasta').val();
                $.ajax({
                    type: "GET",
                    url: "{{url('notaventa/busqueda')}}" + '?page=' + page,
                    data: {
                        desde: desde,
                        hasta: hasta,
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
                let desde= $('#desde').val();
                let hasta= $('#hasta').val();
                $.ajax({
                    type: "GET",
                    url: "{{url('notaventa/busqueda')}}",
                    data: {
                        desde: desde,
                        hasta: hasta,
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