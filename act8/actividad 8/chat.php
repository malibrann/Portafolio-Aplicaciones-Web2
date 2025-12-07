<?php
session_start();
if (!isset($_SESSION['uid'])) header("Location: index.php");

$con = new mysqli("localhost", "root", "", "chat_uni");
$yo = $_SESSION['uid'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chat Universitario</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <div style="display: flex; gap: 10px;">
            
            <div class="sidebar">
                <h3>Hola, <?php echo $_SESSION['nombre']; ?></h3>
                <a href="index.php?salir=1">Cerrar Sesión</a>
                <hr>
                
                <button class="chat-btn" data-id="0" data-tipo="global"> Chat Global</button>
                
                <h4>Grupos</h4>
                <?php
                $res = $con->query("SELECT * FROM grupos");
                while($g = $res->fetch_assoc()){
                    echo "<button class='chat-btn' data-id='{$g['id']}' data-tipo='grupo'> {$g['nombre']}</button>";
                }
                ?>
                
                <h4>Usuarios</h4>
                <?php
                $res = $con->query("SELECT * FROM usuarios WHERE id != $yo");
                while($u = $res->fetch_assoc()){
                    echo "<button class='chat-btn' data-id='{$u['id']}' data-tipo='priv'> {$u['nombre']}</button>";
                }
                ?>
            </div>

            <div class="chat-container" style="flex: 1;">
                <h2 id="titulo-chat">Chat Global</h2>
                
                <div id="chat"></div>

                <input type="hidden" id="para" value="0">
                <input type="hidden" id="tipo" value="global">
                
                <br>
                <input type="text" id="msg" placeholder="Escribe tu mensaje">
                <button id="send">Enviar</button>
            </div>

        </div>
        <script type="text/javascript" src="script.js"></script>
    </body>
</html>