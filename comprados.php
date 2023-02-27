<?php

include 'conexion.php';

// Instanciamos un objeto Conexion (PDO)
$pdo = new Conexion();

if (isset($_POST['ver'])) {
    $sql = $pdo->prepare("SELECT * FROM comprados");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 hay datos");

    // Mostramos resultados directamente

    $resultado = $sql->fetchAll();

    foreach ($resultado as $row) {
        echo "- <b>" . $row["id_comprado"] . " " . $row["boleto"] . " " . $row["fecha_sorteo"] . "</b><br>";
    }

    exit;
}
