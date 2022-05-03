@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                                <a href="{{url('reportessalidas/')}}">
                                    <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                        <i class="fas fa-arrow-left"></i>Atras
                                    </button>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <div style="display:table; text-align: center;">
                                    <h4 class="text-primary" style="display:table-cell; vertical-align:middle;">Detalles de la nota de salida en fecha y hora: {{$notassalidas->created_at}}</h4>
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div id="tabla">
                                @include('notasalida.datosdns')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection