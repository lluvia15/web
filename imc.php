<?php
$servidor = "localhost";
$user = "root";
$pass = "";
$database = "imc_lluvia";

$connection = mysqli_connect($servidor, $user, $pass, $database);

if (!$connection) {
    die("Fallo en la conexión: " . mysqli_connect_error());
}

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
$edad = isset($_POST["edad"]) ? $_POST["edad"] : 0;
$sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : '';
$altura = isset($_POST["altura"]) ? floatval($_POST["altura"]) : 0;
$peso = isset($_POST["peso"]) ? floatval($_POST["peso"]) : 0;
$fecha_registro = isset($_POST["fecha_registro"]) ? $_POST["fecha_registro"] : '';
$fecha_medicion = isset($_POST["fecha_medicion"]) ? $_POST["fecha_medicion"] : '';

$imc = ($altura > 0) ? $peso / ($altura * $altura) : 0;

if ($imc < 18.5) {
    $clasificacion = "Bajo peso";
} elseif ($imc <= 24.9) {
    $clasificacion = "Saludable";
} elseif ($imc <= 29.9) {
    $clasificacion = "Sobrepeso";
} elseif ($imc <= 34.9) {
    $clasificacion = "Obesidad I";
} elseif ($imc <= 39.9) {
    $clasificacion = "Obesidad II";
} else {
    $clasificacion = "Obesidad III";
}

$stmt = $connection->prepare("INSERT INTO datos_imc (nombre, imc, altura, peso, edad, sexo, clasificacion, fecha_registro, fecha_medicion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdddissss", $nombre, $imc, $altura, $peso, $edad, $sexo, $clasificacion, $fecha_registro, $fecha_medicion);

if ($stmt->execute()) {
    echo '<div style="text-align: center;">';
    echo "<h2>Datos registrados correctamente</h2>";
    echo "<h3>Resumen del usuario:</h3>";
    echo "<ul style='display: inline-block; text-align: left;'>";
    echo "<li><b>Nombre:</b> $nombre</li>";
    echo "<li><b>Edad:</b> $edad</li>";
    echo "<li><b>Sexo:</b> $sexo</li>";
    echo "<li><b>Altura:</b> $altura m</li>";
    echo "<li><b>Peso:</b> $peso kg</li>";
    echo "<li><b>IMC:</b> " . round($imc, 2) . "</li>";
    echo "<li><b>Clasificación:</b> $clasificacion</li>";
    echo "<li><b>Fecha de registro:</b> $fecha_registro</li>";
    echo "<li><b>Fecha de medición:</b> $fecha_medicion</li>";
    echo "</ul>";
    echo "<br><img src='LogoEscala.PNG' alt='Logo Escala' style='margin-top: 20px;'>";
    echo '</div>';
} else {
    echo "<p>Error al insertar: " . $stmt->error . "</p>";
}

$stmt->close();
mysqli_close($connection);
?>
</body>
</html>