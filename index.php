<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
    <section class="formulario">
    <form action="uso.php" method="POST">
      <input type="text" placeholder="Numero Boleto" name="boleto" />
      <br /><br /><br />
      <input type="date" placeholder="fecha del sorteo" name="fecha_sorteo" />
      <br /><br /><br />

      <input type="submit" class="btn" name="enviar" value="Enviar">
    </form>
    </section>
</body>
</html>