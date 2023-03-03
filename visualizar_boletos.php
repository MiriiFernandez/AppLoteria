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
        $stmt = $pdo->prepare("UPDATE premios SET cantidad = 300 WHERE boleto BETWEEN 48700 AND 48799");
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
                echo "- <b>" . $row["boleto"] . " " . " " . $row["fecha_sorteo"] . " " . $row["cantidad"] . "</b><br>";
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
