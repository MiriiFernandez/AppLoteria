<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobar_boletos_ok</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="container">
        <section class="logo">
            <img src="https://www.loteriasyapuestas.es/f/loterias/estaticos/imagenes/topaz/cabecera_EuromillonesAJ_topaz.png" alt="">
        </section>
        <br><br>

        <br><br>

</body>




<?php

// Incluimos el archivo de conexion mediante PDO
include 'conexion.php';


// Instanciamos un objeto Conexion (PDO)
$pdo = new Conexion();

//ALMACENAR BOLETOS COMPRADOS Y PREMIADOS EN LA TABLA DE PREMIOS
try {

    $sql_origen = "SELECT * FROM boletos_premiados UNION SELECT * FROM boletos_comprados";
    $consulta_origen = $pdo->prepare($sql_origen);
    $consulta_origen->execute();
    $datos = $consulta_origen->fetchAll(PDO::FETCH_ASSOC);

    // Finalmente, insertamos los datos en la tabla de destino
    foreach ($datos as $fila) {
        $sql_insert = "INSERT INTO premios (boleto, fecha_sorteo)
                   VALUES (:boleto, :fecha_sorteo)";
        $consulta_insert = $pdo->prepare($sql_insert);
        $consulta_insert->bindParam(':boleto', $fila['boleto']);
        $consulta_insert->bindParam(':fecha_sorteo', $fila['fecha_sorteo']);
        $consulta_insert->execute();
    }

    // Iniciar la transacción
    $pdo->beginTransaction();

    try {
        // Ejecutar la consulta para actualizar la columna
        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 600000 WHERE boleto = 48791");
        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 10000 WHERE boleto = 48790 AND 48792");
        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 300 WHERE boleto BETWEEN 48700 AND 48799");

        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 300 WHERE SUBSTR(boleto,-3) = 791");
        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 120 WHERE SUBSTR(boleto,-2) = 91");
        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 60 WHERE SUBSTR(boleto,-1) = 1 LIMIT 1");


        $stmt->execute();

        // Comprobar si hubo algún error
        $error = $stmt->errorInfo();
        if ($error[0] !== '00000') {
            // Si hubo un error, cancelar la transacción
            $pdo->rollBack();
            echo "Hubo un error al actualizar la columna: " . $error[2];
        } else {
            // Si no hubo errores, confirmar la transacción
            $pdo->commit();
            $sql_origen = "SELECT * FROM premios";
            $consulta_origen = $pdo->prepare($sql_origen);
            $consulta_origen->execute();
            $datos = $consulta_origen->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datos as $row) {
                echo '<p class="fila">' . $row["boleto"] . " " . " " . $row["fecha_sorteo"] . " " . $row["cantidad"] . '</p>';
            }

            echo "<br>";

            //SUMA DE LA COLUMNA CANTIDAD
            foreach ($pdo->query('SELECT SUM(cantidad) FROM premios') as $row) {
                echo '<p class="fila">' . "Suma total de los premios: " . '</p>';
                echo '<p class="fila">' . $row['SUM(cantidad)'] . '</p>';
            }
        }
    } catch (Exception $e) {
        // Si se produjo una excepción, cancelar la transacción
        $pdo->rollBack();
        echo "Hubo un error al actualizar la columna: " . $e->getMessage();
    }
} catch (PDOException $e) {
    echo "Error al copiar los datos: " . $e->getMessage();
}

echo "<br>";
echo " <a href='index.php'><button class='button-29' role='button'>Volver</button> </a>";
