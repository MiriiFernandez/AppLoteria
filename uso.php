<?php
// Incluimos el archivo de conexion mediante PDO
include 'conexion.php';

// Instanciamos un objeto Conexion (PDO)
$pdo = new Conexion();

if (isset($_POST['enviar']) && !empty($_POST['boleto'])  && !empty($_POST['fecha_sorteo'])) {

    // INSERTAR REGISTRO
    $sql = "INSERT INTO comprados (boleto, fecha_sorteo) VALUES (:boleto, :fecha_sorteo)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':boleto', $_POST['boleto']);
    $stmt->bindValue(':fecha_sorteo', $_POST['fecha_sorteo']);
    $stmt->execute();
    $idPost = $pdo->lastInsertId();
    if ($idPost) {

        // MOSTRAR TODA LA TABLA DE BOLETOS COMPRADOS
        $sql = $pdo->prepare("SELECT * FROM comprados");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 hay datos");

        // Mostramos resultados directamente

        $resultado = $sql->fetchAll();

        foreach ($resultado as $row) {
            echo "- <b>" . $row["id_comprado"] . " " . $row["boleto"] . " " . $row["fecha_sorteo"] . "</b><br>";
        }
    }
} else {
    echo "no se puede dejar el campo vacio";
}
