<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Eliminar el registro si se envió el ID a través del POST
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        $sql = "DELETE FROM tabla1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<p>Datos eliminados exitosamente.</p>";
        } else {
            echo "<p>Error al eliminar los datos: " . $stmt->error . "</p>";
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
    <title>Registro de Alumnos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #9370DB;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #9370DB;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .btn-back:hover {
            background-color: #8a2be2;
        }
    </style>
</head>
<body>

<h1>Registros Actuales</h1>
<table>
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
    </tr>

    <?php
    // Mostrar los datos en la tabla sin los botones de eliminar
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
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No hay registros disponibles.</td></tr>";
    }

    // Cerrar la conexión
    $conn->close();
    ?>
</table>
  <!-- Botón para volver a la página anterior -->
  <a href="index.html" class="btn-back">Volver</a>
</body>
</html>