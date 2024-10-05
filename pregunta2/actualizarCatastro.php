<?php
include "conexion.inc.php";

// Verificamos si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibimos los datos del formulario
    $id = $_POST["id"];
    $zona = $_POST["zona"];
    $Xini = $_POST["Xini"];
    $Yini = $_POST["Yini"];
    $Xfin = $_POST["Xfin"];
    $Yfin = $_POST["Yfin"];
    $superficie = $_POST["superficie"];
    $distrito = $_POST["distrito"];
    $ci = $_POST["ci"];

    // Preparamos la consulta para actualizar
    $sql = "UPDATE catastro SET zona = ?, Xini = ?, Yini = ?, Xfin = ?, Yfin = ?, superficie = ?, distrito = ?, ci = ? WHERE id = ?";

    // Preparamos la declaración
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Vinculamos los parámetros
        mysqli_stmt_bind_param($stmt, "sddddsssi", $zona, $Xini, $Yini, $Xfin, $Yfin, $superficie, $distrito, $ci, $id);
        
        // Ejecutamos la declaración
        if (mysqli_stmt_execute($stmt)) {
            // Redireccionamos a index.php después de una actualización exitosa
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar: " . mysqli_stmt_error($stmt) . "</div>";
        }
        
        // Cerramos la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error al preparar la consulta: " . mysqli_error($con) . "</div>";
    }
} else {
    // Si no se envió el formulario, buscamos el registro en la base de datos
    $id = $_GET["id"]; // Asegúrate de que el parámetro sea "id" si estás utilizando un identificador
    $sql = "SELECT * FROM catastro WHERE id = ?";
    
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id); // El ID es un entero
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado) {
            $fila = mysqli_fetch_array($resultado);
            if ($fila) {
                // Asignamos los valores a las variables
                $zona = $fila["zona"];
                $Xini = $fila["Xini"];
                $Yini = $fila["Yini"];
                $Xfin = $fila["Xfin"];
                $Yfin = $fila["Yfin"];
                $superficie = $fila["superficie"];
                $distrito = $fila["distrito"];
                $ci = $fila["ci"];
            } else {
                echo "<div class='alert alert-warning'>No se encontró el registro con ID: $id</div>";
                exit;
            }
        } else {
            echo "<div class='alert alert-danger'>Error en la consulta: " . mysqli_stmt_error($stmt) . "</div>";
            exit;
        }
        
        // Cerramos la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error al preparar la consulta: " . mysqli_error($con) . "</div>";
        exit;
    }
}
?>

<html>
<head>
    <title>Editar Catastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <div class="container mt-5">
        <h1>Editar Catastro</h1>
        <form action="actualizarCatastro.php" method="POST">
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="number" class="form-control" name="id" value="<?php echo htmlspecialchars($id); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="zona" class="form-label">Zona</label>
                <input type="text" class="form-control" id="zona" name="zona" value="<?php echo htmlspecialchars($zona); ?>"  required>
            </div>
            <div class="mb-3">
                <label for="Xini" class="form-label">X Inicial</label>
                <input type="number" class="form-control" id="Xini" name="Xini" value="<?php echo htmlspecialchars($Xini); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="Yini" class="form-label">Y Inicial</label>
                <input type="number" class="form-control" id="Yini" name="Yini" value="<?php echo htmlspecialchars($Yini); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="Xfin" class="form-label">X Final</label>
                <input type="number" class="form-control" id="Xfin" name="Xfin" value="<?php echo htmlspecialchars($Xfin); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="Yfin" class="form-label">Y Final</label>
                <input type="number" class="form-control" id="Yfin" name="Yfin" value="<?php echo htmlspecialchars($Yfin); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="superficie" class="form-label">Superficie</label>
                <input type="text" class="form-control" id="superficie" name="superficie" value="<?php echo htmlspecialchars($superficie); ?>" required>
            </div>
            <div class="mb-3">
                <label for="distrito" class="form-label">Distrito</label>
                <input type="text" class="form-control" id="distrito" name="distrito" value="<?php echo htmlspecialchars($distrito); ?>" required>
            </div>
            <div class="mb-3">
                <label for="ci" class="form-label">CI</label>
                <input type="number" class="form-control" id="ci" name="ci" value="<?php echo htmlspecialchars($ci); ?>" readonly>
            </div>
            <button name="aceptar" class='btn btn-primary'>Aceptar</button>
            <a href="index.php" class='btn btn-danger'>Cancelar</a>
        </form>
    </div>
</body>
</html>
