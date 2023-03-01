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
    $result = $stmt->execute(array(':fecha_sorteo' => $fecha_sorteo, ':boleto' => $boleto));
    $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);

    if (count($rows)) {
        foreach ($rows as $row) {
            print("Boleto: " . " " . $row->boleto . " " . "Fecha Sorteo: " . $row->fecha_sorteo . " " . "Dinero: " . $row->dinero);
        }
    } else {
        echo "el boleto que has introducido no esta entre los premiados";
    }
}

// VISUALIZACION RESULTADO BOLETOS
if (isset($_POST['boletosR'])) {

    try {
        /* Iniciar una transacción, desactivando 'autocommit' */
        $pdo->beginTransaction();

        /* Cambiar el esquema y datos de la base de datos */
        $pdo->exec("INSERT INTO acomulados(boleto, fecha_sorteo, premio)
        SELECT boleto, fecha_sorteo, premio FROM comprados");

        /* Actualizar columna premio de la tabla acomulados, basado en el valor del boleto y la fecha de sorteo*/
        $pdo->exec("UPDATE acomulados ac
        SET ac.premio = ( SELECT pre.dinero FROM premios pre WHERE ac.boleto = pre.boleto AND ac.fecha_sorteo = pre.fecha_sorteo)");

        $pdo->commit();
    } catch (Exception $e) {
        /* Reconocer un error y revertir los cambios */
        $pdo->rollBack();
        echo "Fallo: " . $e->getMessage();
    }

    //VISUALIZAR TABLA 
    $sql = $pdo->prepare("SELECT * FROM acomulados");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 hay datos");

    // Mostramos resultados directamente

    $resultado = $sql->fetchAll();

    foreach ($resultado as $row) {
        echo "- <b>" . $row["boleto"] . " " . $row["fecha_sorteo"] . " " . $row["premio"] . "</b><br>";
    }
    //sumar el mismo campo
    foreach ($pdo->query('SELECT SUM(premio) FROM acomulados') as $row) {
        echo "<tr>";
        echo "<td>" . $row['SUM(premio)'] . "</td>";
        echo "";
    }
}
