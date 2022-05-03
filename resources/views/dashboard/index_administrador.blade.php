@extends('principal')
@section('contenido')
    <div class="content" style="padding-bottom: 0px">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                        <div class="card card-chart">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <h5 class="card-category">Ventas y salidas en la semana</h5>
                                        <h3 class="card-title"> Montos en Bs</h3>
                                        <h5 class="text-info">Monto Total Semanal:</h5>
                                        <h5 class="card-title">Registrado: {{$monto_total_semanal_registrado->monto_registrado}} Bs, Devuelto: {{$monto_total_semanal_devuelto->monto_devuelto}} Bs, Pérdida: {{$monto_total_semanal_salida->perdida_registrado}} Bs</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="canvas" height="300" width="600"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                        <div class="card card-tasks" style="height: 200px;">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <h4 class="text-primary" class="card-title">Ingresos, Egresos y Pérdidas</h4>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="table-full-width table-responsive">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <input type="date" id="desde" name="desde" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <input type="date" id="hasta" name="hasta" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <button class="btn btn-sm btn-primary">Calcular</button>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6 class="card-title">Ingresos: <span id="ingresos">{{$ingresos->ingresos}}</span> Bs</h6>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="card-title">Egresos: <span id="egresos">{{$egresos->egresos}}</span> Bs</h6>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="card-title">Pérdidas: <span id="perdidas">{{$perdidas->perdidas}}</span> Bs</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-tasks" style="height: 243px;">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <h4 class="text-primary" class="card-title">Lista de productos con bajo stock</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body " style="height: 275px;">
                                <div class="table-full-width table-responsive" style="height: 150px;">
                                    <table class="table">
                                        <thead class="text-primary" class="blockquote blockquote-primary">
                                            <tr>
                                                <th class="text-info" scope="col">Nombre y Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($tallasproductos) == 0)
                                                <tr>
                                                    <td>No existe productos con bajo stock</td>
                                                </tr>
                                            @else
                                            @foreach ($tallasproductos as $item)
                                                <tr>
                                                    <td style="padding-bottom: 20px; padding-top: 20px">{{$item->producto->nombre}} {{$item->talla->nombre}} con stock: {{$item->stock}}</td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var notas_de_ventas_registrado = {!! json_encode($notas_de_ventas_registrado) !!}; 
        var notas_de_ventas_devuelto = {!! json_encode($notas_de_ventas_devuelto) !!};
        var notas_de_salidas_registrado = {!! json_encode($notas_de_salidas_registrado) !!}; 

        var registrados = [0, 0, 0, 0 ,0, 0, 0]
        var devueltos = [0, 0, 0, 0 ,0, 0, 0]
        var salidas = [0, 0, 0, 0 ,0, 0, 0]
        
        registrados.forEach(function(element, index) {
            notas_de_ventas_registrado.forEach(element2 => {
                if(element2.dia == 'Sun' && index == 0){
                    registrados[index] = element2.contadores;
                }
                if(element2.dia == 'Mon' && index == 1){
                     registrados[index] = element2.contadores;
                }
                if(element2.dia == 'Tue' && index == 2){
                     registrados[index] = element2.contadores;
                }
                if(element2.dia == 'Wed' && index == 3){
                     registrados[index] = element2.contadores;
                }
                if(element2.dia == 'Thu' && index == 4){
                     registrados[index] = element2.contadores;
                }
                if(element2.dia == 'Fri' && index == 5){
                     registrados[index] = element2.contadores;
                }
                if(element2.dia == 'Sat' && index == 6){
                     registrados[index] = element2.contadores;
                }
            });
        });

        devueltos.forEach(function(element, index) {
            notas_de_ventas_devuelto.forEach(element2 => {
                if(element2.dia == 'Sun' && index == 0){
                    devueltos[index] = element2.contadores;
                }
                if(element2.dia == 'Mon' && index == 1){
                     devueltos[index] = element2.contadores;
                }
                if(element2.dia == 'Tue' && index == 2){
                     devueltos[index] = element2.contadores;
                }
                if(element2.dia == 'Wed' && index == 3){
                     devueltos[index] = element2.contadores;
                }
                if(element2.dia == 'Thu' && index == 4){
                     devueltos[index] = element2.contadores;
                }
                if(element2.dia == 'Fri' && index == 5){
                     devueltos[index] = element2.contadores;
                }
                if(element2.dia == 'Sat' && index == 6){
                     devueltos[index] = element2.contadores;
                }
            });
        });

        salidas.forEach(function(element, index) {
            notas_de_salidas_registrado.forEach(element2 => {
                if(element2.dia == 'Sun' && index == 0){
                    salidas[index] = element2.contadores;
                }
                if(element2.dia == 'Mon' && index == 1){
                     salidas[index] = element2.contadores;
                }
                if(element2.dia == 'Tue' && index == 2){
                     salidas[index] = element2.contadores;
                }
                if(element2.dia == 'Wed' && index == 3){
                     salidas[index] = element2.contadores;
                }
                if(element2.dia == 'Thu' && index == 4){
                     salidas[index] = element2.contadores;
                }
                if(element2.dia == 'Fri' && index == 5){
                     salidas[index] = element2.contadores;
                }
                if(element2.dia == 'Sat' && index == 6){
                     salidas[index] = element2.contadores;
                }
            });
        });

        // console.log(notas_de_ventas_registrado);
        // console.log(notas_de_ventas_devuelto);
        // console.log(registrados);
        // console.log(devueltos);
        
        const ctx = document.getElementById('canvas').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                datasets: [
                    {
                        label: 'Ventas Registrados',
                        data: registrados,
                        // backgroundColor: [    
                        //     'rgba(54, 162, 235, 0.2)',
                        // ],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        
                        borderWidth: 2
                    },
                    {
                        label: 'Ventas Devueltas',
                        data: devueltos,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Pérdidas',
                        data: salidas,
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        $(document).ready(function(){
            $("button").click(function(){
                let desde= $('#desde').val();
                let hasta= $('#hasta').val();
                console.log(desde);
                $.ajax({
                    type: "GET",
                    url: "{{url('dashboard/calcular')}}",
                    data: {
                        desde: desde,
                        hasta: hasta
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response);
                        $("#ingresos").text(response.ingresos.ingresos);
                        $("#egresos").text(response.egresos.egresos);
                        $("#perdidas").text(response.perdidas.perdidas);
                    },
                    error: function (jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            });
        });
    </script>
@endsection