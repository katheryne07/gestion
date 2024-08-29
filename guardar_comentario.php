<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas'); // Asegúrate de que el nombre de la base de datos sea correcto

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$comentario = isset($_POST['comentarios']) ? $_POST['comentarios'] : '';

// Consulta para insertar el comentario en la base de datos
$sql = "INSERT INTO comentarios (comentario) VALUES (?)";
$stmt = $conn->prepare($sql);

// Verifica si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular parámetros y ejecutar la consulta
$stmt->bind_param("s", $comentario);

if (!$stmt->execute()) {
    die("Error al guardar el comentario: " . $stmt->error);
}

// Redirigir a la página donde se muestran los comentarios
header("Location: ver_comentarios.php");
exit();

$stmt->close();
$conn->close();
?>