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

    // Finalmente, insertamos los datos en la tabla premios
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
        // Ejecutar la consulta para actualizar el campo

        /* En caso de que termine con 48791 se le añadiran esa cantidad, en caso de que el boleto
        sea entre los números 48700 y 48799, obviaremos los boletos con NOT LIKE para que no se sobreescriban entre si
        si termina con __791 se le añadiran esa cantidad, si termina ___91 se le añadiran esa cantidad
        y si termina con ____1 se le añadira otra cantidad, con % compararemos el final de un campo con un número especifico */
       
        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 
        CASE 
            WHEN boleto LIKE '%48791' THEN  600000 
            WHEN boleto LIKE '%487__' AND boleto NOT LIKE '%48791' THEN 10000
            WHEN boleto LIKE '%791' THEN 300
            WHEN boleto LIKE '%91' AND boleto NOT LIKE '%791' THEN 120
            WHEN boleto LIKE '%1' AND boleto NOT LIKE '%91' AND boleto NOT LIKE '%791' THEN 60
            ELSE cantidad
        END
        WHERE boleto LIKE '%1' OR boleto LIKE '%91' OR boleto LIKE '%791' OR boleto LIKE '%487%';");


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
