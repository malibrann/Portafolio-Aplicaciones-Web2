<?php
session_start();
$con = new mysqli("localhost", "root", "", "chat_uni");

$accion = $_POST['accion'] ?? '';
$yo     = $_SESSION['uid'] ?? 0;

if ($accion == "enviar") {
    $para = $_POST['para'];
    $msg  = $_POST['msg'];
    $tipo = $_POST['tipo'];

    if($msg != ""){
        $sql = "INSERT INTO msj (de, para, mensaje, tipo) VALUES ('$yo', '$para', '$msg', '$tipo')";
        $con->query($sql);
    }
}

if ($accion == "leer") {
    $otro = $_POST['para'];
    $tipo = $_POST['tipo'];

    if ($tipo == 'global') {
        $sql = "SELECT m.mensaje, u.nombre FROM msj m JOIN usuarios u ON m.de = u.id WHERE m.tipo='global' ORDER BY m.id ASC";
    } 
    elseif ($tipo == 'grupo') {
        $sql = "SELECT m.mensaje, u.nombre FROM msj m JOIN usuarios u ON m.de = u.id WHERE m.tipo='grupo' AND m.para='$otro' ORDER BY m.id ASC";
    } 
    else {
        $sql = "SELECT m.mensaje, u.nombre FROM msj m JOIN usuarios u ON m.de = u.id 
                WHERE m.tipo='priv' AND ( (m.de='$yo' AND m.para='$otro') OR (m.de='$otro' AND m.para='$yo') ) 
                ORDER BY m.id ASC";
    }

    $res = $con->query($sql);
    while($fila = $res->fetch_assoc()){
        echo "<div><b>{$fila['nombre']}:</b> {$fila['mensaje']}</div>";
    }
}
?>