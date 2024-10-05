<?php
include "conexion.inc.php";

// Verificamos si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibimos los datos del formulario
    $ci = $_POST["ci"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    
    // Preparamos la consulta para actualizar
    $sql = "UPDATE persona SET nombre = ?, paterno = ? WHERE ci = ?";
    
    // Preparamos la declaración
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Vinculamos los parámetros
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $apellido, $ci);
        
        // Ejecutamos la declaración
        if (mysqli_stmt_execute($stmt)) {
            // Redireccionamos a index.php después de una actualización exitosa
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar: " . mysqli_error($con) . "</div>";
        }
        
        // Cerramos la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error al preparar la consulta: " . mysqli_error($con) . "</div>";
    }
} else {
    // Si no se envió el formulario, buscamos la persona
    $id = $_GET["ci"];
    $sql = "SELECT * FROM persona WHERE ci LIKE '$id'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado) {
        $fila = mysqli_fetch_array($resultado);
        if ($fila) {
            $ci = $fila["ci"];
            $nombre = $fila["nombre"];
            $apellido = $fila["paterno"];
        } else {
            echo "<div class='alert alert-warning'>No se encontró la persona con CI: $id</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>Error en la consulta: " . mysqli_error($con) . "</div>";
        exit;
    }
}
?>

<html>
<head>
    <title>Editar Persona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <div class="container mt-5">
        <h1>Editar Persona</h1>
        <form action="actualizarPersona.php" method="POST">
            <div class="mb-3">
                <label for="ci" class="form-label">CI</label>
                <input type="text" class="form-control" id="ci" name="ci" value="<?php echo htmlspecialchars($ci); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Paterno</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>
            </div>
            <button name="aceptar" class='btn btn-primary'>Aceptar</button>
            <a href="index.php" class='btn btn-danger'>Cancelar</a>
        </form>
    </div>
</body>
</html>
