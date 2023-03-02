<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>index</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <section class="formulario">
    <form action="uso.php" method="POST">
      <input type="text" placeholder="Numero Boleto" name="boleto" />
      <br /><br />
      <input type="date" placeholder="fecha del sorteo" name="fecha_sorteo" />
      <br /><br />

      <input type="submit" class="btn" name="enviar" value="Guardar y ver Boletos">
    </form>

    <br><br><br>
    <form action="comprobar_boleto.php" method="POST">
      <input type="text" placeholder="Numero Boleto" name="boleto" />
      <br /><br />
      <input type="date" placeholder="fecha del sorteo" name="fecha_sorteo" />
      <br /><br />
      <input type="submit" class="btn" name="premiado" value="Comprobar Boleto">
      <input type="submit" class="btn" name="boletosR" value="Visualizar Resultado de los Boletos ">
    </form>
  </section>

  <br><br>
  <table style="width:50%">
    <tr>
      <th>PREMIO</th>
    </tr>
    <tr>
      <td>6000.000</td>
    </tr>
    <tr>
      <td>10.000</td>
    </tr>
    <tr>
      <td>300</td>
    </tr>
    <tr>
      <td>120</td>
    </tr>
    <tr>
      <td>60</td>
    </tr>
    
  </table>
</body>

</html>