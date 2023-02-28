<?php
// Incluimos el archivo de conexion mediante PDO
include 'conexion.php';

// Instanciamos un objeto Conexion (PDO)
$pdo = new Conexion();

if (isset($_POST['premiado']) && !empty($_POST['boleto'])  && !empty($_POST['fecha_sorteo'])) {

    $boleto = $_POST['boleto'];
    $fecha_sorteo = $_POST['fecha_sorteo'];

    $sql = 'SELECT boleto, fecha_sorteo, dinero FROM premios WHERE fecha_sorteo = :fecha_sorteo and boleto = :boleto';
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(array(':fecha_sorteo' =>$fecha_sorteo, ':boleto' => $boleto));
    $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);

    if (count($rows)) {
        foreach ($rows as $row) {
            print("Boleto: " . " " . $row->boleto. " " . "Fecha Sorteo: " .$row->fecha_sorteo . " " . "Dinero: " . $row->dinero); 
        }
    } else{
        echo "el boleto que has introducido no esta entre los premiados";
    }


}
