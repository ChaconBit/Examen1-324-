<?php
// Incluir archivo de conexión a la base de datos
include "conexion.inc.php";

// Verificar si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $ci = $_POST["ci"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];

    // Validar que no haya campos vacíos
    if (empty($ci) || empty($nombre) || empty($apellido)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO persona (ci, nombre, paterno) VALUES ('$ci', '$nombre', '$apellido')";
    
    // Ejecutar la consulta
    if (mysqli_query($con, $sql)) {
        // Redirigir a la página de personas después de guardar
        header("Location: index.php"); // Cambia esto a la URL de tu página de personas
        exit;
    } else {
        echo "Error al agregar la persona: " . mysqli_error($con);
    }
}

// Código HTML para mostrar el formulario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Crear Persona</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .form-container {
            max-width: 500px; /* Ancho máximo del formulario */
            margin: auto; /* Centrar el formulario */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h1 class="text-center mb-4">Crear Persona</h1>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="ci" class="form-label">CI</label>
                    <input type="text" class="form-control" id="ci" name="ci" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
