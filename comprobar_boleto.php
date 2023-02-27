<?php
// Incluimos el archivo de conexion mediante PDO
include 'conexion.php';

// Instanciamos un objeto Conexion (PDO)
$pdo = new Conexion();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_POST['premiado']) && !empty($_POST['boleto'])  && !empty($_POST['fecha_sorteo'])) {

        // COMPROBAR QUE EL BOLETO INTRODUCIDO SE ENCUENTRE EN LA TABLA DE BOLETOS PREMIADOS
        $query = $pdo->prepare("SELECT * FROM premios WHERE boleto=:boleto and fecha_sorteo=:fecha_sorteo");
        $sql->bindValue(':boleto', $_GET['boleto']);
        $sql->bindValue(':fecha_sorteo', $_GET['fecha_sorteo']);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 hay datos");

        // Mostramos resultados

        $comparacion = $query->fetchAll();

        foreach ($comparacion as $row) {
            echo "- <b>" . $row["id_premio"] . " " . $row["boleto"] . " " . $row["fecha_sorteo"] . " " . $row["dinero"] . "</b><br>";
        }
    }
}
