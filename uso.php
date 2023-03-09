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
        <h3>¡Se han guardado con exito!</h3>
        <br><br>
        <a href="index.php"><button class="button-29" role="button">Volver</button> </a>
</body>

</html>

<?php
// Incluimos el archivo de conexion mediante PDO
include 'conexion.php';


// Instanciamos un objeto Conexion (PDO)
$pdo = new Conexion();


//ALMACENAR BOLETOS COMPRADOS
if (isset($_POST['enviar']) && !empty($_POST['boleto'])  && !empty($_POST['fecha_sorteo'])) {

    // INSERTAR REGISTRO
    $sql = "INSERT INTO boletos_comprados (boleto, fecha_sorteo) VALUES (:boleto, :fecha_sorteo)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':boleto', $_POST['boleto']);
    $stmt->bindValue(':fecha_sorteo', $_POST['fecha_sorteo']);
    $stmt->execute();
    $idPost = $pdo->lastInsertId();
    
    if ($idPost) {
        header("HTTP/1.1 200 Ok");
    }
} else {
    echo "no se puede dejar el campo vacio";
}
