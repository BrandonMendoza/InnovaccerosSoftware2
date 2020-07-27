<!DOCTYPE html>
<html lang="en">
  <head>
    <style>

      @page { 
        margin:0px; 
        padding: 10px 10px 10px 10px;
      } 
      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      } 
      .page-break {
        page-break-after: always;
      }


      a {
        color: #5D6975;
        text-decoration: underline;
      }

      body {
        position: relative;
        width: auto;  
        height: auto; 
        margin: 10px; 
        color: #001028;
        background: #FFFFFF; 
        font-size: 12px; 
      }

      header {
        padding: 10px 0;
        margin-bottom: 0px;
      }

      #logo {
        text-align: left;
        margin-bottom: 10px;
      }

      #logo img {
        width: 200px;
      }

      h1 {
        border-top: 1px solid  #5D6975;
        border-bottom: 1px solid  #5D6975;
        color: black;
        font-size: 2.4em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        background: url(dimension.png);
      }

      #project {
        float: left;
      }

      #project span {
        color: #5D6975;
        text-align: left;
        width: 50px;
        margin-right: 20px;
        display: inline-block;
        font-size: 0.8em;
      }

      #company {
        float: right;
        text-align: right;
      }

      #project div,
      #company div {
        white-space: nowrap;        
      }

      table {
        width: 100%;
        border-spacing: 0;
        margin-bottom: 10px;
      }

      table tr:nth-child(2n-1) td {
      }

      table th,
      table td {
        text-align: center;
      }

      table th {
        padding: 20px 20px;
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;        
        font-weight: normal;
      }

      table .service,
      table .desc {
        text-align: left;
      }

      #tdTotales {
        padding: 20px;
        text-align: center;
      }

      #tdheader {
        padding: 20px;
        text-align: left;
      }

      table td.service,
      table td.desc {
        vertical-align: top;
      }

      table td.unit,
      table td.qty,
      table td.total {
        font-size: 1.2em;
      }

      table td.grand {
        border-top: 1px solid #5D6975;
      }

      #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
      }

      footer {
        color: black;
        width: 100%;
        height: auto;
        bottom: 0;
        border: 1px solid black;
        padding: 5px 0;
        text-align: center;
      }

      #desc2{
        width: auto;
      }
    </style>
    <meta charset="utf-8">
    <title>Costeo</title>
  </head>
  <body>
    <header class="clearfix">
      <table style="margin-bottom: 0px; ">
        <thead >
          <tr style="height: 80px;  " >
            <td id="tdheader" style="width: 100px; padding-bottom: 0px; ">
              <div id="logo">
                <img src="{{ public_path()."/img/innlogo.jpg" }}"  alt="">
              </div>
            </td>
            <td id="tdheader" style="padding-bottom: 0px; ">
              <div id="project2">
              <div><span></span> IME1507013U9</div>
              <div><span></span> INNOVACCEROS DE MEXICALI  S de R L de CV</div>
              <div><span></span> Av. Miguel Bravo No. 1101 Int. C</div>
              <div><span></span> Col. Independencia</div>
              <div><span></span> CP 21290 Mexicali B.C.</div>
              <div><span></span> {{ date('Y-m-d H:i:s') }}</div>
          </div>
        </td>
            <td id="tdheader" style="text-align: right; padding-bottom: 0px; ">
              <div id="project2">
              <div>Folio: <b>{{ $proyecto->id }}</b></div>
              <div>Proyecto: <b>{{ $proyecto->nombre_trabajo }}</b></div>
              <div>Cliente: <b>{{ $proyecto->cliente->nombre_cliente}}</b></div>
              <div>Cotizadr: <b>Eduardo Mendoza</b></div>
              <div>Asunto/Subject:  <b>QUOTE</b></div>
              <div>Con atencion a/Atention to: <b>{{$proyecto->atencion_a}}</b></div>
          </div>
       </td>
          </tr>
        </thead>
      </table>
    <div style="text-align: center; margin-top: 0px;  padding-top: 5px;">
      <span style="text-align:center; ">
        INNOVAMOS LAS IDEAS EN ACERO  OBRA CIVIL, ESTRUCTURA, TUBERÍA DE ALTA Y BAJA PRESIÓN/ <br>
        Innovating ideas in civil engineering, steel structures and high/low pressure piping.
      </span>
    </div>
    <div style="text-align: center; width: 100%; margin-top: 0px;border-top: 1px solid #C1CED9; background-color: yellow; padding-top: 5px;">
      <span style="text-align:center; font-size: 20px; ">
        {{ $proyecto->nombre_trabajo }}
      </span>
    </div>
        
    </header>
    <main >
      
      <table >
        <thead >
          <tr >
            <th style="width: 20px;" colspan="2" class="desc">Concepto/Concept</th>
            <th style="width: 4px;">U/M</th>
            <th style="width: 4px;">CTD/QTY</th>
            <th style="width: 4px;">PRICE</th>
            <th style="width: 4px;">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cotizaciones as $id => $cotizacion)
          <tr>
            <td colspan="2" class="desc2"
              style="text-align: left;width: 20px;">
                {!! nl2br($cotizacion->descripcion_individual) !!}
            </td>
            <td style="vertical-align: top;">{{$cotizacion->unidad_medida->unidad_medida}}</td>
            <td style="vertical-align: top;" class="qty">{{$cotizacion->cantidad}}</td>
            <td style="vertical-align: top;" class="unit">{{ '$'.number_format($cotizacion->total_general,2) }}</td>
            <td style="vertical-align: top;" class="total">{{ '$'.number_format($cotizacion->total_general*$cotizacion->cantidad,2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>


    </main>
    <footer>
      <table style="padding-right: 35px;">
        <thead hidden>
          <tr hidden>
            <td id="tdTotales" class="desc" colspan="2"></th>
            <td id="tdTotales" style="width: 10px;"></th>
            <td id="tdTotales" style="width: 10px;"></th>
            <td id="tdTotales" style="width: 10px;"></th>
            <td id="tdTotales" style="width: 10px;"></th>
            <td id="tdTotales" style="width: 10px;"></th>
          </tr>
        </thead>
        <tbody >
          <tr>
            <td id="tdTotales"  style="text-align: left:"><span class="font-weight-bold">
              "Condiciones de Pago: </span> dias despues de la entrega/
              Payment terms: days after delivery"
            </td>

            <td id="tdTotales" style="width: 10px;">
              {{ $proyecto->tiempo_pago }}
            </td>
            <td></td>
            <td id="tdTotales" colspan=""> 
              <b>SUBTOTAL</b>
            </td>
            <td id="tdTotales" class="total">
              {{ '$'.number_format($totalCotizacion,2) }}
            </td>
          </tr>
          <tr>
            <td id="tdTotales" style="text-align: left:"><span class="font-weight-bold">
                 "Tiempo de entrega: </span> dias habiles despues de la entrega de la orden de compra
                Delivery time, Days after purchase order reception:"
            </td>
            <td id="tdTotales"> {{ $proyecto->dias_habiles }}</td>

            <td id="tdTotales"></td>
            <td id="tdTotales" colspan=""><b>IVA 16%</b></td>
            <td id="tdTotales" class="total">{{ '$'.number_format($totalCotizacion*0.16,2) }}</td>
            
          </tr>
          <tr style="">
            <td id="tdTotales" style="text-align: left:"><span class="font-weight-bold">
              "Valides de la Cotizacion:  </span>
              </span>
            </td>
            <td id="tdTotales" style="width: 10px;">{{$proyecto->valides}}</td>
            <td id="tdTotales" ></td>
            <td id="tdTotales" colspan="" class="grand total"><b>TOTAL</b></td>
            <td id="tdTotales" class="grand total">{{ '$'.number_format($totalCotizacion*1.16, 2) }}</td>
          </tr>
        </tbody>
      </table>
    </footer>
  </body>
</html>