<?php
    include "conexion.inc.php";
    // Corregimos la variable $ci
    $ci = $_GET["ci"];
    
    // Preparamos la consulta SQL para eliminar el registro
    $sql1 = "DELETE FROM catastro WHERE ci='$ci'";
    $sql2 = "DELETE FROM persona WHERE ci='$ci'";
    
    // Ejecutamos la consulta
    mysqli_query($con, $sql1);
    mysqli_query($con, $sql2);
    
    // Redirigimos al usuario a la página principal
    header("Location: index.php");
?>
