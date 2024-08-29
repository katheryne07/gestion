<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del alumno desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar los datos del alumno con ese ID
$sql = "SELECT * FROM tabla1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el registro
if ($result->num_rows > 0) {
    $alumno = $result->fetch_assoc();
} else {
    die("No se encontró ningún alumno con el ID proporcionado.");
}

// Consultar todos los registros
$sql_all = "SELECT * FROM tabla1";
$result_all = $conn->query($sql_all);

$stmt->close();
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
            
            <th>Nombre</th>
            <th>Género</th>
            <th>Jornada</th>
            <th>Grado</th>
            <th>Modalidad</th>
            <th>Sección</th>
            <th>Deportes</th> <!-- Nuevo campo -->
            <th>Nota I Semestre</th>
            <th>Nota II Semestre</th>
            <th>Promedio</th>
            <th>Observaciones</th>
        </tr>
        <?php while ($row = $result_all->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['genero']; ?></td>
            <td><?php echo $row['jornada']; ?></td>
            <td><?php echo $row['grado']; ?></td>
            <td><?php echo $row['modalidad']; ?></td>
            <td><?php echo $row['seccion']; ?></td>
            <td><?php echo $row['deportes']; ?></td> <!-- Mostrar el nuevo campo -->
            <td><?php echo $row['nota1']; ?></td>
            <td><?php echo $row['nota2']; ?></td>
            <td><?php echo $row['promedio']; ?></td>
            <td><?php echo $row['observaciones']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Botón para volver a la página anterior -->
    <a href="index_agregar.html" class="btn-back">Volver</a>
</body>
</html>