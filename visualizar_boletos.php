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

    $pdo->beginTransaction();

    $pdo->exec("UPDATE premios SET cantidad = 300 WHERE boleto BETWEEN 48700 AND 48799");

    $pdo->commit();

    foreach ($datos as $row) {
        echo "- <b>" . $row["boleto"] . " " . $row["fecha_sorteo"] . " " . "</b><br>";
    }
} catch (PDOException $e) {
    echo "Error al copiar los datos: " . $e->getMessage();
}
