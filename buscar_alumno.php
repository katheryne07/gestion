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
    <title>Buscar y Modificar Datos del Alumno</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .img-container {
            position: absolute;
            top: 0;
            left: 0;
        }
        .img-container img {
            width: 150px; /* Ajusta el ancho */
            height: auto; /* Mantiene la proporción de la imagen */
        }
    </style>
</head>
<body>
    <div class="img-container">
        <img src="https://th.bing.com/th/id/OIP.epZx8VR4OfbwNhHchL7LUQHaIn?rs=1&pid=ImgDetMain" alt="Imagen en la esquina superior izquierda">
    </div>
    <style>
        body {
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            color: #7246c9;
            margin-bottom: 20px;
        }
        table {
            background-color: #d0bbf3;
            border-collapse: collapse;
            width: 70%;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #a67efd;
            color: white;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }
        td {
            border-bottom: 1px solid #ddd;
        }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="radio"], input[type="checkbox"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #9370DB;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #8464C3;
        }
        form {
            width: 100%;
        }
        textarea {
            width: 90%;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-header {
            text-align: center;
        }
        @media (max-width: 768px) {
            table {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h1>Buscar y Modificar Datos del Alumno</h1>
        </div>

        <!-- Formulario para buscar por ID -->
        <form action="buscar_alumno.php" method="post">
            <center>
                <table>
                    <tr>
                        <th><label for="buscar_id">Buscar por ID del Alumno:</label></th>
                        <td><input type="text" name="buscar_id" id="buscar_id" required></td>
                    </tr>
                </table>
                <input type="submit" value="Buscar Alumno"><br>
            </center>
        </form>

        <?php if (isset($alumno)): ?>
        <!-- Formulario para modificar datos del alumno -->
        <form action="modificar.php" method="post">
            <table>
                <tr>
                    <th><label for="nombre">Nombre Completo del Alumno:</label></th>
                    <td><input type="text" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required></td>
                </tr>
                <tr>
                    <th><label>Género:</label></th>
                    <td>
                        <input type="radio" id="genero_masculino" name="genero" value="Masculino" <?php echo $alumno['genero'] == 'Masculino' ? 'checked' : ''; ?>>
                        <label for="genero_masculino">Masculino</label>
                        <input type="radio" id="genero_femenino" name="genero" value="Femenino" <?php echo $alumno['genero'] == 'Femenino' ? 'checked' : ''; ?>>
                        <label for="genero_femenino">Femenino</label>
                    </td>
                </tr>
                <tr>
                    <th><label>Jornada:</label></th>
                    <td>
                        <input type="radio" id="jornada_matutina" name="jornada" value="Matutina" <?php echo $alumno['jornada'] == 'Matutina' ? 'checked' : ''; ?>>
                        <label for="jornada_matutina">Matutina</label>
                        <input type="radio" id="jornada_vespertina" name="jornada" value="Vespertina" <?php echo $alumno['jornada'] == 'Vespertina' ? 'checked' : ''; ?>>
                        <label for="jornada_vespertina">Vespertina</label>
                    </td>
                </tr>        
                <tr>
                    <th><label for="grado">Grado:</label></th>
                    <td>
                        <select name="grado">
                            <option value="Séptimo" <?php echo $alumno['grado'] == 'Séptimo' ? 'selected' : ''; ?>>Séptimo</option>
                            <option value="Octavo" <?php echo $alumno['grado'] == 'Octavo' ? 'selected' : ''; ?>>Octavo</option>
                            <option value="Noveno" <?php echo $alumno['grado'] == 'Noveno' ? 'selected' : ''; ?>>Noveno</option>
                            <option value="Décimo" <?php echo $alumno['grado'] == 'Décimo' ? 'selected' : ''; ?>>Décimo</option>
                            <option value="Undécimo" <?php echo $alumno['grado'] == 'Undécimo' ? 'selected' : ''; ?>>Undécimo</option>
                            <option value="Duodécimo" <?php echo $alumno['grado'] == 'Duodécimo' ? 'selected' : ''; ?>>Duodécimo</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="modalidad">Modalidad:</label></th>
                    <td>
                        <input type="radio" id="modalidad1" name="modalidad" value="Educ. Básica" <?php echo $alumno['modalidad'] == 'Educ. Básica' ? 'checked' : ''; ?>>
                        <label for="modalidad1">Educ. Básica</label><br>
                        <input type="radio" id="modalidad2" name="modalidad" value="BTP" <?php echo $alumno['modalidad'] == 'BTP' ? 'checked' : ''; ?>>
                        <label for="modalidad2">BTP</label><br>
                        <input type="radio" id="modalidad3" name="modalidad" value="BCH Ciencias y Humanidades" <?php echo $alumno['modalidad'] == 'BCH Ciencias y Humanidades' ? 'checked' : ''; ?>>
                        <label for="modalidad3">BCH Ciencias y Humanidades</label><br>
                        <input type="radio" id="modalidad4" name="modalidad" value="BTP Informática" <?php echo $alumno['modalidad'] == 'BTP Informática' ? 'checked' : ''; ?>>
                        <label for="modalidad4">BTP Informática</label><br>
                        <input type="radio" id="modalidad5" name="modalidad" value="BTP Hotelería y Turismo" <?php echo $alumno['modalidad'] == 'BTP Hotelería y Turismo' ? 'checked' : ''; ?>>
                        <label for="modalidad5">BTP Hotelería y Turismo</label><br>
                        <input type="radio" id="modalidad6" name="modalidad" value="Admin. de Empresas" <?php echo $alumno['modalidad'] == 'Admin. de Empresas' ? 'checked' : ''; ?>>
                        <label for="modalidad6">Admin. de Empresas</label><br>
                        <input type="radio" id="modalidad7" name="modalidad" value="Contaduría y Finanzas" <?php echo $alumno['modalidad'] == 'Contaduría y Finanzas' ? 'checked' : ''; ?>>
                        <label for="modalidad7">Contaduría y Finanzas</label>
                    </td>
                </tr>
                <tr>
                    <th><label for="seccion">Sección:</label></th>
                    <td>
                        <input type="radio" id="seccionU" name="seccion" value="U" <?php echo $alumno['seccion'] == 'U' ? 'checked' : ''; ?>>
                        <label for="seccionU">U</label>
                        <input type="radio" id="seccionA" name="seccion" value="A" <?php echo $alumno['seccion'] == 'A' ? 'checked' : ''; ?>>
                        <label for="seccionA">A</label>
                        <input type="radio" id="seccionB" name="seccion" value="B" <?php echo $alumno['seccion'] == 'B' ? 'checked' : ''; ?>>
                        <label for="seccionB">B</label>
                        <input type="radio" id="seccionC" name="seccion" value="C" <?php echo $alumno['seccion'] == 'C' ? 'checked' : ''; ?>>
                        <label for="seccionC">C</label>
                        <input type="radio" id="seccionD" name="seccion" value="D" <?php echo $alumno['seccion'] == 'D' ? 'checked' : ''; ?>>
                        <label for="seccionD">D</label>            
                    </td>
                </tr> 
                <tr>
                    <th><label for="deportes">Deportes que practica:</label></th>
                    <td>
                        <input type="checkbox" id="deporte1" name="deportes[]" value="Fútbol" <?php echo in_array('Fútbol', explode(',', $alumno['deportes'])) ? 'checked' : ''; ?>>
                        <label for="deporte1">Fútbol</label><br>
                        <input type="checkbox" id="deporte2" name="deportes[]" value="Baloncesto" <?php echo in_array('Baloncesto', explode(',', $alumno['deportes'])) ? 'checked' : ''; ?>>
                        <label for="deporte2">Baloncesto</label><br>
                        <input type="checkbox" id="deporte3" name="deportes[]" value="Natación" <?php echo in_array('Natación', explode(',', $alumno['deportes'])) ? 'checked' : ''; ?>>
                        <label for="deporte3">Natación</label><br>
                        <input type="checkbox" id="deporte4" name="deportes[]" value="Tenis" <?php echo in_array('Tenis', explode(',', $alumno['deportes'])) ? 'checked' : ''; ?>>
                        <label for="deporte4">Tenis</label><br>
                        <input type="checkbox" id="deporte5" name="deportes[]" value="Ciclismo" <?php echo in_array('Ciclismo', explode(',', $alumno['deportes'])) ? 'checked' : ''; ?>>
                        <label for="deporte5">Ciclismo</label><br>
                        <input type="checkbox" id="deporte6" name="deportes[]" value="No" <?php echo in_array('No', explode(',', $alumno['deportes'])) ? 'checked' : ''; ?>>
                        <label for="deporte6">No practico ningún deporte</label><br>
                    </td>            
                </tr>
                <tr>
                    <th><label for="nota1">Nota I Semestre:</label></th>
                    <td><input type="number" step="0.01" name="nota1" value="<?php echo htmlspecialchars($alumno['nota1']); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="nota2">Nota II Semestre:</label></th>
                    <td><input type="number" step="0.01" name="nota2" value="<?php echo htmlspecialchars($alumno['nota2']); ?>" required></td>
                </tr>
            </table>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($alumno['id']); ?>">
            <center><input type="submit" value="Modificar Datos"></center>
        </form>
        <?php endif; ?>

</body>
</html>