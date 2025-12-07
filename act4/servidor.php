<?php

    $servidor="localhost";
    $usuario="root";
    $contraseña="";
    $bd="ejercicio";
    $num = $_GET["num"];
    $datos = Array();
    $conexion=mysqli_connect($servidor,$usuario,$contraseña,$bd);

    if($num == 0){
        $consulta="SELECT id, nombre FROM paises";
        $resultado = mysqli_query($conexion,$consulta);

        if($resultado->num_rows>0){
            while($fila=$resultado->fetch_assoc()){
                $datos[] = $fila;
            }
        }

        echo json_encode($datos);
    }

    if($num == 1){
        $id = $_GET["id"];
        $consulta="SELECT id, nombre FROM estados WHERE id_pais = $id";
        $resultado = mysqli_query($conexion,$consulta);

        if($resultado->num_rows>0){
            while($fila=$resultado->fetch_assoc()){
                $datos[] = $fila;
            }
        }

        echo json_encode($datos);
    }

    if($num == 2){
        $id = $_GET["id"];
        $consulta="SELECT id, nombre FROM municipios WHERE id_estado = $id";
        $resultado = mysqli_query($conexion,$consulta);

        if($resultado->num_rows>0){
            while($fila=$resultado->fetch_assoc()){
                $datos[] = $fila;
            }
        }

        echo json_encode($datos);
    }
?>