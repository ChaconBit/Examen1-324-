<?php
// Incluir archivo de conexión a la base de datos
include "conexion.inc.php";

if (isset($_GET['id_distrito'])) {
    $id_distrito = $_GET['id_distrito'];

    // Consulta para obtener zonas según el ID del distrito
    $query = "SELECT * FROM zona WHERE id_distrito = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_distrito);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $zonas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $zonas[] = $row; // Agregar cada zona al array
    }

    // Devolver las zonas como JSON
    echo json_encode($zonas);
} else {
    echo json_encode([]); // Devolver un array vacío si no hay ID
}
?>
