<?php
session_start();
$con = new mysqli("localhost", "root", "", "chat_uni");

if (isset($_GET['salir'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $pass = $_POST["pass"];

    $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        $fila = $res->fetch_assoc();
        if ($pass == $fila['pass']) {
            $_SESSION['uid'] = $fila['id'];
            $_SESSION['nombre'] = $fila['nombre'];
            header("Location: chat.php");
        }
    } else {
        $sql = "INSERT INTO usuarios (nombre, pass) VALUES ('$nombre', '$pass')";
        if ($con->query($sql)) {
            $_SESSION['uid'] = $con->insert_id;
            $_SESSION['nombre'] = $nombre;
            header("Location: chat.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat-container">
        <h2>Bienvenido</h2>
        <form method="post">
            <div class="label">Nombre:</div>
            <input type="text" name="nombre" required>
            <div class="label">Contraseña:</div>
            <input type="password" name="pass" required>
            <button type="submit">Entrar / Registrar</button>
        </form>
    </div>
</body>
</html>