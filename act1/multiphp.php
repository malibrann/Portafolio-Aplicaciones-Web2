<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Multiplicar</title>
</head>
<body>
    <div class="container">
        <h1>Generador de Tabla de Multiplicar</h1>
        
        <!-- Formulario -->
        <form method="POST" action="">
            <label for="multiplicando">Multiplicando (número a multiplicar):</label>
            <input type="number" id="multiplicando" name="multiplicando" required>
            
            <label for="limite">Límite (hasta qué número multiplicar):</label>
            <input type="number" id="limite" name="limite" min="1" required>
            
            <button type="submit">Generar Tabla</button>
        </form>
        
        <?php
        // Verificar si se envió el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los valores del formulario
            $multiplicando = $_POST['multiplicando'];
            $limite = $_POST['limite'];
            
            // Validar que los valores sean números válidos
            if (is_numeric($multiplicando) && is_numeric($limite) && $limite > 0) {
                echo "<div class='resultado'>";
                echo "<h2>Tabla del $multiplicando hasta el $limite:</h2>";
                
                // Generar la tabla de multiplicar
                for ($i = 1; $i <= $limite; $i++) {
                    $resultado = $multiplicando * $i;
                    echo "<div class='tabla-item'>";
                    echo "$multiplicando x $i = $resultado";
                    echo "</div>";
                }
                
                echo "</div>";
            } else {
                echo "<div style='color: red; padding: 10px; background-color: #ffebee; border-radius: 5px;'>";
                echo "Por favor, ingresa números válidos. El límite debe ser mayor a 0.";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>