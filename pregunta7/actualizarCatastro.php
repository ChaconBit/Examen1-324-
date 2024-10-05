<?php
include "conexion.inc.php";

// Verificamos si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibimos los datos del formulario
    $id_distrito = $_POST['distrito'];
    $idZona = $_POST['zona']; // Asegúrate de que el ID de la zona se esté enviando

    // Consulta para obtener el nombre del distrito
    $query = "SELECT nombre FROM distrito WHERE id = ?";
    $stmtDistrito = mysqli_prepare($con, $query);
    
    // Vincular el parámetro y ejecutar la consulta
    mysqli_stmt_bind_param($stmtDistrito, "i", $id_distrito);
    mysqli_stmt_execute($stmtDistrito);
    mysqli_stmt_bind_result($stmtDistrito, $nombre_distrito);
    mysqli_stmt_fetch($stmtDistrito);
    mysqli_stmt_close($stmtDistrito);

    // Consulta para obtener el nombre de la zona
    $queryx = "SELECT nombre FROM zona WHERE id = ?";
    $stmtZona = mysqli_prepare($con, $queryx);
    
    // Vincular el parámetro y ejecutar la consulta
    mysqli_stmt_bind_param($stmtZona, "i", $idZona);
    mysqli_stmt_execute($stmtZona);
    mysqli_stmt_bind_result($stmtZona, $nombre_zona);
    mysqli_stmt_fetch($stmtZona);
    mysqli_stmt_close($stmtZona);

    // Asignar el nombre del distrito y la zona
    $distrito = $nombre_distrito;
    $zona = $nombre_zona;

    // Recoger los datos del formulario en el orden solicitado
    $di = $_POST["id"]; // Se recoge el ID
    $Xini = $_POST["Xini"];
    $Yini = $_POST["Yini"];
    $Xfin = $_POST["Xfin"];
    $Yfin = $_POST["Yfin"];
    $superficie = $_POST["superficie"];
    $ci = $_POST["ci"]; // Asegúrate de que el CI se esté enviando

    // Validar que no haya campos vacíos
    if (empty($di) || empty($zona) || empty($Xini) || empty($Yini) || empty($Xfin) || empty($Yfin) || empty($superficie) || empty($distrito) || empty($ci)) {
        echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
        exit;
    }

    // Preparamos la consulta para actualizar
    $sql = "UPDATE catastro SET zona = ?, Xini = ?, Yini = ?, Xfin = ?, Yfin = ?, superficie = ?, distrito = ?, ci = ? WHERE id = ?";

    // Preparamos la declaración
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Vinculamos los parámetros
        mysqli_stmt_bind_param($stmt, "sddddisss", $zona, $Xini, $Yini, $Xfin, $Yfin, $superficie, $distrito, $ci, $di);
        
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
    $id = $_GET["id"]; // Asegúrate de que el parámetro sea "id"
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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Actualizar Catastro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h1 class="text-center mb-4">Actualizar Catastro</h1>
            <form id="catastroForm" method="POST">
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($id); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="distrito" class="form-label">Distrito</label>
                    <select class="form-select" id="distrito" name="distrito" required>
                        <option value="">Seleccione un distrito</option>
                        <?php
                        // Obtener distritos de la base de datos
                        $query = "SELECT * FROM distrito";
                        $result = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['id'] == $id_distrito) ? 'selected' : ''; // Se corrige para usar id_distrito
                            echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="zona" class="form-label">Zona</label>
                    <select class="form-select" id="zona" name="zona" required>
                        <option value="">Seleccione una zona</option>
                        <!-- Las opciones de zona serán rellenadas dinámicamente mediante AJAX -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="Xini" class="form-label">X Inicio</label>
                    <input type="text" class="form-control" id="Xini" name="Xini" required value="<?php echo htmlspecialchars($Xini); ?>"> 
                </div>
                <div class="mb-3">
                    <label for="Yini" class="form-label">Y Inicio</label>
                    <input type="text" class="form-control" id="Yini" name="Yini" required value="<?php echo htmlspecialchars($Yini); ?>">
                </div>
                <div class="mb-3">
                    <label for="Xfin" class="form-label">X Fin</label>
                    <input type="text" class="form-control" id="Xfin" name="Xfin" required value="<?php echo htmlspecialchars($Xfin); ?>">
                </div>
                <div class="mb-3">
                    <label for="Yfin" class="form-label">Y Fin</label>
                    <input type="text" class="form-control" id="Yfin" name="Yfin" required value="<?php echo htmlspecialchars($Yfin); ?>">
                </div>
                <div class="mb-3">
                    <label for="superficie" class="form-label">Superficie</label>
                    <input type="text" class="form-control" id="superficie" name="superficie" value="<?php echo htmlspecialchars($superficie); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ci" class="form-label">CI</label>
                    <input type="text" class="form-control" id="ci" name="ci" value="<?php echo htmlspecialchars($ci); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>

    <!-- JQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Evento para cargar zonas cuando se selecciona un distrito
        document.getElementById('distrito').addEventListener('change', function() {
            var distritoId = this.value;

            // Hacer la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'getZonas.php?id_distrito=' + distritoId, true); // Corrected URL
            xhr.onload = function() {
                if (this.status === 200) {
                    var zonas = JSON.parse(this.responseText);
                    var zonasSelect = document.getElementById('zona');

                    // Limpiar el menú de zonas
                    zonasSelect.innerHTML = '<option value="">Seleccione una zona</option>';

                    // Rellenar el menú de zonas
                    zonas.forEach(function(zona) {
                        var option = document.createElement('option');
                        option.value = zona.id;
                        option.textContent = zona.nombre;
                        zonasSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        });
    </script>
</body>
</html>
