<style type="text/css">
  #logo {
        text-align: left;
        margin-bottom: 10px;
      }

      #logo img {
        width: 200px;
        height: 200px;
      }
      #tdheader {
        padding: 20px;
        text-align: left;
      }
</style>
      <table style="margin-bottom: 0px; ">
        <thead >
          <tr style="height: 80px;" >
            <td id="tdheader" style="width: 100px; padding-bottom: 0px; ">
              <div id="logo">
            
                <img src="{{ public_path()."\img\innlogo.png" }}"  alt="">
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