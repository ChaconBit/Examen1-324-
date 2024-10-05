<?php
$texto = 'HOLA MUNDO';
$colores = ['#FF5733', '#33FF57', '#3357FF', '#F333FF', '#FFD733', '#33FFF5', '#FF33A6', '#F3FF33', '#FF5733', '#3357FF', '#33FF57', '#F333FF'];

echo '<br><br><h1>';
foreach (str_split($texto) as $index => $letra) {
    $color = $colores[$index % count($colores)]; // Obtener color en función del índice
    echo "<span style='color: $color;'>$letra</span>";
}
echo '</h1>';
?>
