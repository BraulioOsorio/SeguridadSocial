<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      .table-container {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
      }

      .table-header {
        text-align: center;
        border-bottom: 1px solid #ddd;
        border-right: 1px solid #ddd;
      }

      .table-cell {
        padding: 8px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        border-right: 1px solid #ddd;
      }
    </style>
  </head>
  <body>
    <h1>Tu factura</h1>

    <table class="table-container">
      <thead>
          <tr class="table-header">
              <th class="table-cell">Cliente</th>
              <th class="table-cell">Plan</th>
              <th class="table-cell">Total Pagado</th>
              <th class="table-cell">Monto Recibido</th>
              <th class="table-cell">Devuelta</th>
              <th class="table-cell">Fecha Pago</th>
          </tr>
      </thead>
      <tbody>
          <tr class="text-center">
          <?php
          if (!empty($vdata)) {
              extract($vdata);
              var_dump($vdata);
          }
          ?>
              <td class="table-cell"> 
                  <?php
                      if(isset($empresa)){
                          echo $empresa;
                      }else{
                          echo $trabajador;
                      }
                  ?>
              </td>
              <td class="table-cell"> <?= $plan; ?> </td>
              <td class="table-cell"> <?= number_format($monto, 2, '.', ','); ?> </td>
              <td class="table-cell"> <?= number_format($dineroRecibido, 2, '.', ','); ?> </td>
              <td class="table-cell"> <?= number_format($devuelta, 2, '.', ','); ?> </td>
              <td class="table-cell"> <?= $fecha; ?> </td>
          </tr>
      </tbody>
  </table>    
  </body>
</html>
