<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletos comprados</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="container">
        <section class="logo">
            <img src="https://www.loteriasyapuestas.es/f/loterias/estaticos/imagenes/topaz/cabecera_EuromillonesAJ_topaz.png" alt="">
        </section>
        <br><br>
        <h3>Ingrese el número de boleto, junto a la fecha del sorteo</h3>
        <br><br>
        <form action="uso.php" method="POST">
            <input type="text" placeholder="Nº boleto" name="boleto">
            <br><br>
            <input type="date" placeholder="Fecha del sorteo" name="fecha_sorteo">
            <br><br>

            <input type="submit" value="Guardar" name="enviar">
        </form>
        <br><br><br><br>
        <a href="index.php"><button class="button-29" role="button">Volver</button> </a>
    </section>
</body>

</html>