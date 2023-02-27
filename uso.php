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
        exit;
    }


    // // MOSTRAR BOLETOS COMPRADOS
    // $sql = $pdo->prepare("SELECT * FROM comprados");
    // $sql->execute();
    // $sql->setFetchMode(PDO::FETCH_ASSOC);
    // header("HTTP/1.1 200 hay datos");

    // // Sacamos todos los resultados de la base de datos
    // $resultado = $sql->fetchAll();

    // echo "<br>Mostramos la información de los resultados: <br><br>";

    // //Mostramos resultados
    // foreach ($resultado as $row) {
    //     echo "- <b>" . $row["id_comprado"] . " " . $row["boleto"] . " " . $row["fecha_sorteo"]
    //         . " " . $row["premio"] . "</b><br>";
    // }
}
