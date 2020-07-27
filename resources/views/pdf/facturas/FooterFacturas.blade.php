<footer class="footer">
      <table style="padding-right: 35px;">
        <thead hidden>
          <tr hidden>
            <td id="tdTotales" class="desc" colspan="2"></td>
            <td id="tdTotales" style="width: 10px;"></td>
            <td id="tdTotales" style="width: 10px;"></td>
            <td id="tdTotales" style="width: 10px;"></td>
            <td id="tdTotales" style="width: 10px;"></td>
            <td id="tdTotales" style="width: 10px;"></td>
          </tr>
        </thead>
        <tbody >
          <tr>
            <td id="tdTotales"  style="text-align: left:">
              <span class="font-weight-bold">
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
              {{ '$'.number_format($cotizacion->total_general*$cotizacion->cantidad,2) }}
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
            <td id="tdTotales" class="total">{{ '$'.number_format(($cotizacion->total_general*$cotizacion->cantidad)*0.16,2) }}</td>
            
          </tr>
          <tr style="">
            <td id="tdTotales" style="text-align: left:">
              <span class="font-weight-bold">
                "Valides de la Cotizacion:  
              </span>
            </td>
            <td id="tdTotales" style="width: 10px;">{{$proyecto->valides}}</td>
            <td id="tdTotales" ></td>
            <td id="tdTotales" colspan="" class="grand total"><b>TOTAL</b></td>
            <td id="tdTotales" class="grand total">
              {{ '$'.number_format(($cotizacion->total_general*$cotizacion->cantidad)*1.16, 2) }}
            </td>
          </tr>
        </tbody>
      </table>
    </footer>