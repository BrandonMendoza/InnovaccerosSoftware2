<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }
 
        body {
            margin: 2cm 2cm 3.7cm;
        }
        
        main {
            width: 100%;
            height: 100%;
            float: left;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }
 
        footer {
            position: fixed;
            width: 100%;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3.5cm;
            padding: 0;
            padding-bottom: 10px;
            text-align: center;
        }

        /*   */


        .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 0px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    .invoice-box table tr td.iva,
    .invoice-box table tr td.subtotal {
        border-top: 2px solid #eee;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    #logo {
            text-align: left;
            margin-bottom: 10px;
          }

          #logo img {
            width: 200px;
          }
    </style>
</head>
<body >

 
<main class="invoice-box">

  <table cellpadding="0" cellspacing="0">
      <tr class="top">
          <td colspan="2">
              <table>
                  <tr>
                      <td class="title">
                          <div id="logo">
                            <img src="{{ public_path()."\img\innlogo-min.png" }}" >
                          </div>
                      </td>
                      
                      <td>
                          Cotización #: {{$cotizacion->id}}<br>
                          Creado/Created: {{ date('Y-m-d H:i:s') }}<br>
                          Due/Vence: {{ date('Y-m-d H:i:s') }}
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
      
      <tr class="information">
          <td colspan="2">
              <table>
                  <tr>
                      <td>
                          IME1507013U9<br>
                          INNOVACCEROS DE MEXICALI  S de R L de CV<br>
                          Av. Miguel Bravo No. 1101 Int. C <br>
                          Col. Independencia <br>
                          CP 21290 Mexicali B.C. <br>
                      </td>
                    
                  </div>
                      
                      <td>
                          {{ $proyecto->cliente->nombre_cliente}}<br>
                          @if($proyecto->atencion_a == "") - @else {{$proyecto->atencion_a}} @endif<br>
                          contacto@example.com
                      </td>
                  </tr>
              </table>
          </td>
      </tr>

      <tr>
        <td colspan="2">
          <table cellpadding="0" cellspacing="0">
            <tr class="heading">
              <td>
                #
              </td>
              <td style="text-align: left;">
                Proyecto/Job
              </td>
              <td style="text-align: right;">
                Total + Iva/Taxes
              </td>
            </tr>
          
            <tr class="details">
              <td style="text-align: left;">
                {{ $proyecto->id }}
              </td>
              <td style="text-align: left;">
                {{ $proyecto->nombre_trabajo }}
              </td>
              <td style="text-align: right; font-weight: bold;">
                 {{ '$'.number_format(($cotizacion->total_general*$cotizacion->cantidad)*1.16, 2) }}
              </td>
            </tr>
          </table>
        </td>
      </tr>
  </table>
  <table cellpadding="0" cellspacing="0">
    <tr class="heading">
        <td>Descripción/Description</td>
        <td style="text-align: center;">UM</td>
        <td style="text-align: center;">Ctd/Qty</td>
        <td style="text-align: right;">Precio/Price</td>
        <td style="text-align: right;">Total</td>
    </tr>
      @foreach($descripcion_renglones as $renglon)
        <tr class="item">
            <td  style="text-align: left;">
                {{ $renglon }}
            </td>
            <td style="text-align: center;vertical-align: top;">
                @if($loop->index == 0) 
                    {{ $cotizacion->unidad_medida->unidad_medida  }} 
                @endif
            </td>
            <td style="text-align: center;vertical-align: top;">
                @if($loop->index == 0) 
                    {{$cotizacion->cantidad}}
                @endif
            </td>
            <td style="text-align: right;vertical-align: top;">
                @if($loop->index == 0) 
                    {{ '$'.number_format($cotizacion->total_general,2) }} 
                @endif
            </td>
            <td style="text-align: right;vertical-align: top;">
                @if($loop->index == 0) 
                    {{ '$'.number_format($cotizacion->total_general*$cotizacion->cantidad,2) }}
                @endif
            </td>
        </tr>
    @endforeach
  </table>

  
</main>
 
<footer >
  <div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
    <tr>
        <td></td>
        <td class="subtotal" width="30%">
          Subtotal:   {{ '$'.number_format($cotizacion->total_general*$cotizacion->cantidad,2) }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td class="subtotal" width="30%"> 
          IVA/Taxes: {{ '$'.number_format(($cotizacion->total_general*$cotizacion->cantidad)*0.16,2) }}
        </td>
    </tr>
    
    <tr class="total">
        <td></td>
        
        <td width="30%">
           Total: {{ '$'.number_format(($cotizacion->total_general*$cotizacion->cantidad)*1.16, 2) }}
        </td>
    </tr>
  </table>
  </div>
</footer>
</body>
</html>

