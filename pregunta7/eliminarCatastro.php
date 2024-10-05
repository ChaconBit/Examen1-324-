<?php
    include "conexion.inc.php";
    // Corregimos la variable $id
    $id =(int) $_GET["id"];
    
    // Preparamos la consulta SQL para eliminar el registro
    $sql = "DELETE FROM catastro WHERE id ='$id'";
    
    // Ejecutamos la consulta
    mysqli_query($con, $sql);
    
    // Redirigimos al usuario a la página principal
    header("Location: index.php");
?>
