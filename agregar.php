<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario con validación
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$genero = isset($_POST['genero']) ? $_POST['genero'] : '';
$jornada = isset($_POST['jornada']) ? $_POST['jornada'] : '';
$grado = isset($_POST['grado']) ? $_POST['grado'] : '';
$modalidad = isset($_POST['modalidad']) ? $_POST['modalidad'] : '';
$seccion = isset($_POST['seccion']) ? $_POST['seccion'] : '';
$deportes = isset($_POST['deportes']) ? $_POST['deportes'] : [];
$deportes_str = implode(", ", $deportes); // Convertir el array a una cadena separada por comas
$nota1 = isset($_POST['nota1']) ? $_POST['nota1'] : 0;
$nota2 = isset($_POST['nota2']) ? $_POST['nota2'] : 0;
$promedio = ($nota1 + $nota2) / 2;
$observaciones = ($promedio >= 70) ? 'Aprobado' : 'Reprobado';

// Consulta para insertar los datos en la tabla de alumnos
$sql = "INSERT INTO tabla1 (nombre, genero, jornada, grado, modalidad, seccion, deportes, nota1, nota2, promedio, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verifica si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Cambiar el tipo de definición de acuerdo al tipo de las variables
$stmt->bind_param("sssssssdsss", $nombre, $genero, $jornada, $grado, $modalidad, $seccion, $deportes_str, $nota1, $nota2, $promedio, $observaciones);

// Ejecutar la consulta
if (!$stmt->execute()) {
    die("Error al agregar los datos: " . $stmt->error);
}

// Verificar si la inserción fue exitosa
if ($stmt->affected_rows > 0) {
    // Obtener el ID del nuevo registro
    $new_id = $stmt->insert_id;

    // Insertar comentarios, si existen
    if (isset($_POST['comentarios']) && !empty(trim($_POST['comentarios']))) {
        $comentarios = trim($_POST['comentarios']);
        $sql_comentarios = "INSERT INTO comentarios (comentario) VALUES (?)";
        $stmt_comentarios = $conn->prepare($sql_comentarios);
        
        if ($stmt_comentarios === false) {
            die("Error en la preparación de la consulta de comentarios: " . $conn->error);
        }

        $stmt_comentarios->bind_param("s", $comentarios);
        
        if (!$stmt_comentarios->execute()) {
            die("Error al agregar el comentario: " . $stmt_comentarios->error);
        }
        
        $stmt_comentarios->close();
    }

    // Redirigir a la página de ver_alumno.php con el ID del nuevo registro
    header("Location: ver_alumno.php?id=" . $new_id);
    exit();
} else {
    echo "Error al agregar los datos.";
}

$stmt->close();
$conn->close();
?>