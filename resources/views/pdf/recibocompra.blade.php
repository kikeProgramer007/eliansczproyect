<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de compra</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #gracias{
        text-align: center; 
        }
    </style>
    <body>
        
        <header>
            <div id="logo">
                <img src="{{public_path('img/IconoWeb.png')}}" alt="Concinnity" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>Concinnity</b><br>3er anillo interno/Centro Comercial Norte/Planta alta, local #403 - Santa Cruz de la Sierra, Bolivia<br>Telefono:(+591)73663525<br>Email:concinnity.bo@gmail.com
                </p>
            </div>
            <div id="fact">
                <p>Recibo<br>
                00{{$notaventa->id}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Sr(a). {{$notaventa->cliente->nombre}}<br>
                            Teléfono: {{$notaventa->cliente->telefono}}<br>
                            Email: {{$notaventa->cliente->correo}}</p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        <br>
        
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>VENDEDOR</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notaventa->user->personal->nombre}}</td>
                            <td>{{$notaventa->created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>CANT</th>
                            <th>DESCRIPCION</th>
                            <th>PRECIO UNIT</th>
                            <th>OFERTA</th>
                            <th>PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detallesnotasventas as $detallenotaventa)
                        <tr>
                            <td>{{$detallenotaventa->cantidad}}</td>
                            <td>{{$detallenotaventa->tallaproducto->producto->nombre}}-{{$detallenotaventa->tallaproducto->talla->nombre}}</td>
                            <td>{{$detallenotaventa->precio}}</td>
                            <td>{{$detallenotaventa->tallaproducto->producto->oferta}}</td>
                            <td>{{$detallenotaventa->cantidad*$detallenotaventa->precio-($detallenotaventa->cantidad*$detallenotaventa->precio*$detallenotaventa->tallaproducto->producto->oferta)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>DESCUENTO</th>
                            <td>Bs {{$notaventa->descuento}}</td>
                        </tr>
                        {{-- <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Impuesto</th>
                            <td>Bs {{round($v->total*$v->impuesto,2)}}</td>
                        </tr> --}}
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>TOTAL</th>
                            <td>Bs {{$notaventa->monto_total}}</td>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>
    </body>
</html>