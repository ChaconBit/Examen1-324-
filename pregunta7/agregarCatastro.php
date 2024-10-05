<?php
// Incluir archivo de conexión a la base de datos
include "conexion.inc.php";

// Inicializamos el CI
$ci = ""; 

// Verificamos si se ha recibido el CI a través de la URL
if (isset($_GET["ci"])) {
    $ci = $_GET["ci"];
}

// Verificar si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger el ID del distrito
    $id_distrito = $_POST['distrito'];

    // Consulta para obtener el nombre del distrito
    $query = "SELECT nombre FROM distrito WHERE id = ?";
    $stmtDistrito = mysqli_prepare($con, $query);
    
    // Vincular el parámetro y ejecutar la consulta
    mysqli_stmt_bind_param($stmtDistrito, "i", $id_distrito);
    mysqli_stmt_execute($stmtDistrito);
    mysqli_stmt_bind_result($stmtDistrito, $nombre_distrito);
    mysqli_stmt_fetch($stmtDistrito);
    mysqli_stmt_close($stmtDistrito);

    // Recoger el ID de la zona
    $idZona = $_POST['zona'];
    
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

    // Validar que no haya campos vacíos
    if (empty($di) || empty($zona) || empty($Xini) || empty($Yini) || empty($Xfin) || empty($Yfin) || empty($superficie) || empty($distrito) || empty($ci)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Preparar la consulta SQL para insertar los datos en catastro
    $sqlCatastro = "INSERT INTO catastro (id, zona, Xini, Yini, Xfin, Yfin, superficie, distrito, ci) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtCatastro = mysqli_prepare($con, $sqlCatastro);
    
    // Comprobar si la preparación de la consulta fue exitosa
    if ($stmtCatastro) {
        // Vincular los parámetros, asegurando que los tipos son correctos
        mysqli_stmt_bind_param($stmtCatastro, 'ssddddsss', $di, $zona, $Xini, $Yini, $Xfin, $Yfin, $superficie, $distrito, $ci);
        
        // Ejecutar la consulta de catastro
        if (mysqli_stmt_execute($stmtCatastro)) {
            // Redirigir a la página de personas después de guardar
            header("Location: index.php"); // Cambia esto a la URL de tu página de personas
            exit;
        } else {
            echo "Error al agregar el catastro: " . mysqli_error($con);
        }

        // Cerrar declaración de catastro
        mysqli_stmt_close($stmtCatastro);
    } else {
        echo "Error en la preparación de la consulta de catastro.";
    }
}
// Código HTML para mostrar el formulario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Crear Catastro</title>
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
            <h1 class="text-center mb-4">Crear Catastro</h1>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" name="id" required>
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
                            echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="zona" class="form-label">Zona</label>
                    <select class="form-select" id="zona" name="zona" required>
                        <option value="">Seleccione una zona</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="Xini" class="form-label">X Inicio</label>
                    <input type="text" class="form-control" id="Xini" name="Xini" required>
                </div>
                <div class="mb-3">
                    <label for="Yini" class="form-label">Y Inicio</label>
                    <input type="text" class="form-control" id="Yini" name="Yini" required>
                </div>
                <div class="mb-3">
                    <label for="Xfin" class="form-label">X Fin</label>
                    <input type="text" class="form-control" id="Xfin" name="Xfin" required>
                </div>
                <div class="mb-3">
                    <label for="Yfin" class="form-label">Y Fin</label>
                    <input type="text" class="form-control" id="Yfin" name="Yfin" required>
                </div>
                <div class="mb-3">
                    <label for="superficie" class="form-label">Superficie</label>
                    <input type="text" class="form-control" id="superficie" name="superficie" required>
                </div>
                <div class="mb-3">
                    <label for="ci" class="form-label">CI</label>
                    <input type="text" class="form-control" id="ci" name="ci" value="<?php echo htmlspecialchars($ci); ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button><br><br>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
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
