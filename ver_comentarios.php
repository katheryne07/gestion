







<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener comentarios de la base de datos
$sql = "SELECT * FROM comentarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
</head>
<body style="background-color: #cec3e4;">
    <h1 style="text-align: center; color: ##7246c9;">Comentarios</h1>
    <div style="width: 80%; margin: 0 auto; background-color: #f4f4f4; padding: 20px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
        <?php
        if ($result->num_rows > 0) {
            echo "<ul style='list-style-type: none; padding: 0;'>";
            while ($row = $result->fetch_assoc()) {
                echo "<li style='background-color: #fff; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 10px;'>";
                echo htmlspecialchars($row['comentario']); // Mostrar el comentario de forma segura
                echo " <a href='ver_comentarios.php?delete=" . $row['id'] . "' style='color: #d9534f; text-decoration: none; font-weight: bold;' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este comentario?\");'>Eliminar</a>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='text-align: center; color: #666;'>No hay comentarios.</p>";
        }

        // Eliminar un comentario si se solicita
        if (isset($_GET['delete'])) {
            $delete_id = intval($_GET['delete']); // Asegúrate de que el ID es un entero
            $sql_delete = "DELETE FROM comentarios WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            
            if ($stmt_delete === false) {
                die("Error en la preparación de la consulta de eliminación: " . $conn->error);
            }
            
            $stmt_delete->bind_param("i", $delete_id);
            $stmt_delete->execute();
            
            if ($stmt_delete->affected_rows > 0) {
                echo "<p style='text-align: center; color: #4CAF50;'>Comentario eliminado exitosamente.</p>";
            } else {
                echo "<p style='text-align: center; color: #d9534f;'>Error al eliminar el comentario o comentario no encontrado.</p>";
            }
            $stmt_delete->close();
            
            // Redirigir de nuevo para evitar el reenvío del formulario
            header("Location: ver_comentarios.php");
            exit();
        }

        $conn->close();
        ?>
    </div>
      <!-- Botón para volver a la página anterior -->
      <a href="index.html" class="btn-back">Volver</a>
</body>
</html>