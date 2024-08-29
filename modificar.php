<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió el formulario para modificar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conn->real_escape_string($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $genero = isset($_POST['genero']) ? $conn->real_escape_string($_POST['genero']) : '';
    $jornada = isset($_POST['jornada']) ? $conn->real_escape_string($_POST['jornada']) : '';
    $grado = isset($_POST['grado']) ? $conn->real_escape_string($_POST['grado']) : '';
    $modalidad = isset($_POST['modalidad']) ? $conn->real_escape_string($_POST['modalidad']) : '';
    $seccion = isset($_POST['seccion']) ? $conn->real_escape_string($_POST['seccion']) : '';

    // Asegurarse de que 'deportes' es un array o inicializarlo como un array vacío
    $deportes = isset($_POST['deportes']) ? $_POST['deportes'] : array();
    $deportes_str = implode(', ', $deportes); // Convertir array a string

    $nota1 = isset($_POST['nota1']) ? $conn->real_escape_string($_POST['nota1']) : 0;
    $nota2 = isset($_POST['nota2']) ? $conn->real_escape_string($_POST['nota2']) : 0;
    $promedio = ($nota1 + $nota2) / 2;
    $observaciones = ($promedio >= 6) ? 'Aprobado' : 'Reprobado';

    $query = "UPDATE tabla1 SET nombre='$nombre', genero='$genero', jornada='$jornada', grado='$grado', modalidad='$modalidad', seccion='$seccion', deportes='$deportes_str', nota1='$nota1', nota2='$nota2', promedio='$promedio', observaciones='$observaciones' WHERE id='$id'";

    if ($conn->query($query) === TRUE) {
        echo "Datos del alumno actualizados correctamente.";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="background-color: #cec3e4;">
 <br><a href="buscar_alumno.php" class="btn-back">Volver</a>
</body>