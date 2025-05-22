<?php
$servidor = "localhost";
$user = "root";
$pass = "";
$database = "imc_lluvia";

$connection = mysqli_connect($servidor, $user, $pass, $database);

if (!$connection) {
    die("Fallo en la conexión: " . mysqli_connect_error());
}


$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$calorias =$_POST['calorias_total'];

$sql = "INSERT INTO calorias_diarias (nombre, fecha, calorias_total)
        VALUES ('$nombre', '$fecha', '$calorias')";

if (mysqli_query($connection, $sql)) {
    echo '<div style="text-align: center;">';
    echo "<h2>Calorías registradas correctamente</h2>";
    echo "<h3>Resumen:</h3>";
    echo "<ul style='display: inline-block; text-align: left;'>";
    echo "<li><b>Nombre:</b> $nombre</li>";
    echo "<li><b>Fecha:</b> $fecha</li>";
    echo "<li><b>Calorías totales:</b> $calorias kcal</li>";
    echo "</ul>";
    echo "<br><img src='LogoCalorias.PNG' alt='Logo Calorias' style='margin-top: 20px;'>";
    echo '</div>';
} else {
    echo "<p>Error al insertar: " . mysqli_error($connection) . "</p>";
}

mysqli_close($connection);
?>
</body>
</html>