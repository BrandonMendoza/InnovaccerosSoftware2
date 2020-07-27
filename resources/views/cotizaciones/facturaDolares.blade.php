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
        width: 21cm;  
        height: 29.7cm; 
        margin: 0 auto; 
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
        width: 95%;
        border-collapse: collapse;
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

      table td {
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
        border-top: 1px solid #5D6975;;
      }

      #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
      }

      footer {
        color: black;
        width: 100%;
        height: auto;
        position: absolute;
        bottom: 0;
        border: 1px solid black;
        padding: 5px 0;
        text-align: center;
      }
    </style>
    <meta charset="utf-8">
    <title>Costeo en Dolares</title>
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
            <td id="tdheader" style="padding-bottom: 0px; ">
              <div id="project2">
              <div>Folio: <b>{{ $proyecto->id }}</b></div>
              <div>Proyecto: <b>{{ $cotizacion->trabajo->nombre_trabajo }}</b></div>
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
    <div style="text-align: center; width: 95%; margin-top: 0px;border-top: 1px solid #C1CED9; background-color: yellow; padding-top: 5px;">
      <span style="text-align:center; font-size: 20px; ">
        {{ $cotizacion->trabajo->nombre_trabajo }}
      </span>
    </div>
    



        
    </header>
    <main>
      
      <table>
        <thead>
          <tr>
            <th class="desc" colspan="2">Concepto/Concept</th>
            <th style="width: 5px;">U/M</th>
            <th style="width: 5px;">CTD/QTY</th>
            <th style="width: 5px;">PRICE</th>
            <th style="width: 5px;">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="desc2" colspan="2" 
              style="text-align: left;">
                @for($i = 0; $i < count($descripcion_palabras); $i++)
                  {!! nl2br($descripcion_palabras[$i]) !!}
                  
                  @if($i==400)
                    @php
                    $loop=$i
                    @endphp
                    @break
                    
                  @endif
                @endfor
            </td>
            <td style="vertical-align: top;">Lote</td>
            <td style="vertical-align: top;" class="qty">1</td>
            <td style="vertical-align: top;" class="unit">{{ '$'.number_format((float)$cotizacion->total_general/$proyecto->tipo_cambio,2, '.', '') }}</td>
            <td style="vertical-align: top;" class="total">{{ '$'.number_format((float)$cotizacion->total_general/$proyecto->tipo_cambio,2, '.', '') }}</td>
          </tr>
        </tbody>
      </table>


    </main>
    <footer>
      <table style="padding-right: 35px;">
        <thead hidden>
          <tr  >
            <th class="desc" colspan="2"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: left:"><span class="font-weight-bold">
              "Condiciones de Pago: </span> dias despues de la entrega/
              Payment terms: days after delivery"
            </td>

            <td style="width: 10px;">
              {{ $proyecto->tiempo_pago }}
            </td>
            <td></td>
            <td colspan=""> 
              <b>SUBTOTAL</b>
            </td>
            <td class="total">

              {{ '$'.number_format((float)$cotizacion->total_general/$proyecto->tipo_cambio,2, '.', '') }}
            </td>
          </tr>
          <tr>
            <td style="text-align: left:"><span class="font-weight-bold">
                 "Tiempo de entrega: </span> dias habiles despues de la entrega de la orden de compra
                Delivery time, Days after purchase order reception:"
            </td>
            <td> {{ $proyecto->dias_habiles }}</td>

            <td></td>
            <td colspan=""><b>IVA 16%</b></td>
            <td class="total">{{ '$'.number_format((float)($cotizacion->total_general *0.16)/($proyecto->tipo_cambio),2, '.', '') }}</td>
            
          </tr>
          <tr style="">
            <td style="text-align: left:"><span class="font-weight-bold">
              "Valides de la Cotizacion:  </span>Dias desde su emision
              Quote is Valid Until, Days after Emision"
              </span>
            </td>
            <td style="width: 8px;">30</td>
            <td></td>
            <td colspan="" class="grand total"><b>TOTAL</b></td>
            <td class="grand total">{{ '$'.number_format(((float)$cotizacion->total_general *1.16)/($proyecto->tipo_cambio),2, '.', '') }}</td>
          </tr>
        </tbody>
      </table>
    </footer>



    @if($loop==400)
      <div class="page-break"></div>
      
     

      <main>
      
      <table>
        <thead>
          <tr>
            <th class="desc" colspan="2">Concepto/Concept</th>
            <th style="width: 5px;">U/M</th>
            <th style="width: 5px;">CTD/QTY</th>
            <th style="width: 5px;">PRICE</th>
            <th style="width: 5px;">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="desc2" colspan="2" 
              style="text-align: left;">
                @for($i = $loop+1; $i < count($descripcion_palabras); $i++)
                  {!! nl2br($descripcion_palabras[$i]) !!}
                @endfor
            </td>
            <td style="vertical-align: top;">Lote</td>
            <td style="vertical-align: top;" class="qty">1</td>
            <td style="vertical-align: top;" class="unit">{{ '$'.number_format($cotizacion->total_general/($proyecto->tipo_cambio)) }}</td>
            <td style="vertical-align: top;" class="total">{{ '$'.number_format($cotizacion->total_general/($proyecto->tipo_cambio)) }}</td>
          </tr>
        </tbody>
      </table>


    </main>
    <footer>
      <table style="padding-right: 35px;">
        <thead hidden>
          <tr  >
            <th class="desc" colspan="2"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
            <th style="width: 10px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: left:"><span class="font-weight-bold">
              "Condiciones de Pago: </span> dias despues de la entrega/
              Payment terms: days after delivery"
            </td>

            <td style="width: 10px;">
              {{ $proyecto->tiempo_pago }}
            </td>
            <td></td>
            <td colspan=""> 
              <b>SUBTOTAL</b>
            </td>
            <td class="total">
              {{ '$'.number_format((float)$cotizacion->total_general/$proyecto->tipo_cambio,2, '.', '') }}
            </td>
          </tr>
          <tr>
            <td style="text-align: left:"><span class="font-weight-bold">
                 "Tiempo de entrega: </span> dias habiles despues de la entrega de la orden de compra
                Delivery time, Days after purchase order reception:"
            </td>
            <td> {{ $proyecto->dias_habiles }}</td>

            <td></td>
            <td colspan=""><b>IVA 16%</b></td>
            <td class="total">{{ '$'.number_format((float)$cotizacion->total_general *0.16/($proyecto->tipo_cambio),2, '.', '') }}</td>
            
          </tr>
          <tr style="">
            <td style="text-align: left:"><span class="font-weight-bold">
              "Valides de la Cotizacion:  </span>Dias desde su emision
              Quote is Valid Until, Days after Emision"
              </span>
            </td>
            <td style="width: 10px;">30</td>
            <td></td>
            <td colspan="" class="grand total"><b>TOTAL</b></td>
            <td class="grand total">{{ '$'.number_format((float)$cotizacion->total_general *1.16/($proyecto->tipo_cambio),2, '.', '') }}</td>
          </tr>
        </tbody>
      </table>
    </footer>

    @endif
  </body>
</html>