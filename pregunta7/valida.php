<?php
// Iniciar sesión
session_start();

// Conexión a la base de datos con el usuario root
$con = mysqli_connect("localhost", "root", "", "bdabraham");

// Verificar si la conexión falló
if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener los datos del formulario de login usando POST
$usuario = mysqli_real_escape_string($con, $_POST["usuario"]);
$contrasenia = mysqli_real_escape_string($con, $_POST["contrasenia"]);

// Consulta SQL para verificar el usuario y la contraseña
$sql = "SELECT COUNT(*) AS cantidad, rol FROM usuario WHERE usuario = '$usuario' AND contrasenia = '$contrasenia'";
$resultado = mysqli_query($con, $sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    $fila = mysqli_fetch_array($resultado);
    
    // Si el usuario existe
    if ($fila["cantidad"] != 0) {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["rol"] = $fila["rol"];
        header("Location: index.php"); // Redirigir a la página principal
    } else {
        header("Location: login.php"); // Redirigir a la página de login si falla
    }
} else {
    // Si hubo un error en la consulta
    echo "Error en la consulta: " . mysqli_error($con);
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
