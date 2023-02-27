<?php
// Incluimos el archivo de conexion mediante PDO
include 'conexion.php';

// Instanciamos un objeto Conexion (PDO)
$pdo = new Conexion();

if (isset($_POST['enviar'])) {

    // INSERTAR REGISTRO
    $sql = "INSERT INTO comprados (boleto, fecha_sorteo) VALUES (:boleto, :fecha_sorteo)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':boleto', $_POST['boleto']);
    $stmt->bindValue(':fecha_sorteo', $_POST['fecha_sorteo']);
    $stmt->execute();
    $idPost = $pdo->lastInsertId();
    if ($idPost) {
        header("HTTP/1.1 200 Ok");
    }

    exit;
}
