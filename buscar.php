<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'registro de notas');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$alumno = null;

// Verificar si se envió el formulario para buscar el ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_id'])) {
    $id = intval($_POST['buscar_id']);

    // Consultar el registro del alumno por ID
    $sql = "SELECT * FROM tabla1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $alumno = $result->fetch_assoc();
    } else {
        $error = "No se encontró ningún alumno con ese ID.";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Datos del Alumno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 20px;
        }
        table {
            background-color: #d0bbf3;
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #a67efd;
            color: white;
        }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="text"][readonly], input[type="number"][readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
        input[type="submit"] {
            background-color: #9370DB;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #8464C3;
        }
    </style>
</head>
<body>
    <h1>Buscar Datos del Alumno</h1>

    <!-- Formulario para buscar por ID -->
    <form action="buscar.php" method="post">
        <table>
            <tr>
                <th><label for="buscar_id">Buscar por ID del Alumno:</label></th>
                <td><input type="text" name="buscar_id" id="buscar_id" required></td>
            </tr>
        </table>
        <input type="submit" value="Buscar Alumno">
    </form>

    <!-- Suponiendo que el alumno ha sido encontrado, mostrar el formulario para modificar -->
    <?php if (isset($alumno)): ?>
    <form method="post">
        <table>
            <tr>
                <th><label for="id">ID del Alumno:</label></th>
                <td><input type="text" name="id" id="id" value="<?php echo htmlspecialchars($alumno['id']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="nombre">Nombre Completo del Alumno:</label></th>
                <td><input type="text" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="genero">Género:</label></th>
                <td><input type="text" name="genero" value="<?php echo htmlspecialchars($alumno['genero']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="jornada">Jornada:</label></th>
                <td><input type="text" name="jornada" value="<?php echo htmlspecialchars($alumno['jornada']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="grado">Grado:</label></th>
                <td><input type="text" name="grado" value="<?php echo htmlspecialchars($alumno['grado']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="modalidad">Modalidad:</label></th>
                <td><input type="text" name="modalidad" value="<?php echo htmlspecialchars($alumno['modalidad']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="seccion">Sección:</label></th>
                <td><input type="text" name="seccion" value="<?php echo htmlspecialchars($alumno['seccion']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="deportes">Deportes:</label></th>
                <td><input type="text" name="deportes" value="<?php echo htmlspecialchars($alumno['deportes']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="nota1">Nota I Semestre:</label></th>
                <td><input type="number" step="0.01" name="nota1" value="<?php echo htmlspecialchars($alumno['nota1']); ?>" readonly></td>
            </tr>
            <tr>
                <th><label for="nota2">Nota II Semestre:</label></th>
                <td><input type="number" step="0.01" name="nota2" value="<?php echo htmlspecialchars($alumno['nota2']); ?>" readonly></td>
            </tr>
        </table>
    </form>
    <?php endif; ?>
</body>
</html>