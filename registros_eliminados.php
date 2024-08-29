<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro_de_notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Eliminar el registro si se envió el ID a través del POST
if (isset($_POST['eliminar'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        $sql = "DELETE FROM tabla1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "<p>Registro eliminado correctamente.</p>";
        } else {
            echo "<p>Error al eliminar el registro: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
    } else {
        echo "<p>ID no válido.</p>";
    }
}

// Mostrar todos los registros actuales
$sql = "SELECT * FROM tabla1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Registro</title>
</head>
<body>

<h1>Registros Actuales</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Género</th>
        <th>Jornada</th>
        <th>Grado</th>
        <th>Modalidad</th>
        <th>Sección</th>
        <th>Deportes</th>
        <th>Nota I Semestre</th>
        <th>Nota II Semestre</th>
        <th>Acción</th>
    </tr>

    <?php
    // Mostrar los datos en la tabla
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['nombre'] . "</td>
                    <td>" . $row['genero'] . "</td>
                    <td>" . $row['jornada'] . "</td>
                    <td>" . $row['grado'] . "</td>
                    <td>" . $row['modalidad'] . "</td>
                    <td>" . $row['seccion'] . "</td>
                    <td>" . $row['deportes'] . "</td>
                    <td>" . $row['nota1'] . "</td>
                    <td>" . $row['nota2'] . "</td>
                    <td>
                        <form method='POST' action=''>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <input type='submit' name='eliminar' value='Eliminar'>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No hay registros disponibles.</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>
