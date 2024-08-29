<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar todos los registros
$sql_all = "SELECT * FROM tabla1";
$result_all = $conn->query($sql_all);

// Verificar si se obtuvieron resultados
if ($result_all === false) {
    die("Error en la consulta: " . $conn->error);
}

$conn->close();
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
<body style="background-color: #cec3e4;">
    <center><h1 style="color: #7246c9;">Registro de Alumnos</h1></center>

    <h3 style="color: #7246c9;">Todos los Registros</h3>
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
            <th>Promedio</th>
            <th>Observaciones</th>
        </tr>
        <?php while ($row = $result_all->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['genero']); ?></td>
            <td><?php echo htmlspecialchars($row['jornada']); ?></td>
            <td><?php echo htmlspecialchars($row['grado']); ?></td>
            <td><?php echo htmlspecialchars($row['modalidad']); ?></td>
            <td><?php echo htmlspecialchars($row['seccion']); ?></td>
            <td><?php echo htmlspecialchars($row['deportes']); ?></td>
            <td><?php echo htmlspecialchars($row['nota1']); ?></td>
            <td><?php echo htmlspecialchars($row['nota2']); ?></td>
            <td><?php echo htmlspecialchars($row['promedio']); ?></td>
            <td><?php echo htmlspecialchars($row['observaciones']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Botón para volver a la página anterior -->
    <a href="index.html" class="btn-back">Volver</a>
</body>
</html>