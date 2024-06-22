<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones de Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
        }
        .header {
            background-color: #b3cde0;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label,
        .form-group select,
        .form-group input,
        .form-group textarea {
            display: block;
            margin: 0 auto;
            text-align: left;
        }
        .form-group select,
        .form-group input,
        .form-group textarea {
            padding: 8px;
            width: 300px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .footer {
            background-color: #b3cde0;
            padding: 10px;
            text-align: center;
            position: absolute;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Formulario de Reservación</h1>
    </div>
    <div class="container">
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="hotel">Seleccione el Hotel:</label>
                <select id="hotel" name="hotel" required>
                    <option value="Hotel Ritz-Carlton">Hotel Ritz-Carlton</option>
                    <option value="Hotel Four Seasons">Hotel Four Seasons</option>
                    <option value="Hotel Plaza">Hotel Plaza</option>
                    <option value="Hotel Waldorf Astoria">Hotel Waldorf Astoria</option>
                    <option value="Hotel Burj Al Arab">Hotel Burj Al Arab</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre del Cliente:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" >
            </div>
            <div class="form-group">
                <label for="fechaReservacion">Fecha de Reservación:</label>
                <input type="date" id="fechaReservacion" name="fechaReservacion" required>
            </div>
            <div class="form-group">
                <label for="observaciones">Observaciones:</label>
                <textarea id="observaciones" name="observaciones" rows="4"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Procesar</button>
            </div>
        </form>
    </div>
    <div class="container">
        <h2>Reservaciones</h2>
        <?php

        define("ARCHIVO_RESERVACIONES","reservaciones.txt" );


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $hotel = isset($_POST['hotel']) ? htmlspecialchars($_POST['hotel']) : '';
            $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
            $apellido = isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : '';
            $telefono = isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '';
            $fechaReservacion = isset($_POST['fechaReservacion']) ? htmlspecialchars($_POST['fechaReservacion']) : '';
            $observaciones = isset($_POST['observaciones']) ? htmlspecialchars($_POST['observaciones']) : '';

            // Validación de campos
            if (empty($hotel) || empty($nombre) || empty($apellido) || empty($telefono) || empty($fechaReservacion)) {
                echo "<p style='color:red;'>Todos los campos son requeridos.</p>";
            } else {
                $reservacion = "$hotel,$nombre,$apellido,$telefono,$fechaReservacion,$observaciones\n";
                file_put_contents(ARCHIVO_RESERVACIONES, $reservacion, FILE_APPEND);
                echo "<p style='color:green;'>Reservación realizada con éxito.</p>";
            }
        }

        // Leer y mostrar las reservaciones
        if (file_exists(ARCHIVO_RESERVACIONES)) {
            $reservaciones = file(ARCHIVO_RESERVACIONES, FILE_IGNORE_NEW_LINES);
            if (!empty($reservaciones)) {
                echo "<table>
                        <tr>
                            <th>Hotel</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                        </tr>";
                foreach ($reservaciones as $reservacion) {
                    $datos = explode(",", $reservacion);
                    echo "<tr>
                            <td>$datos[0]</td>
                            <td>$datos[1]</td>
                            <td>$datos[2]</td>
                            <td>$datos[3]</td>
                            <td>$datos[4]</td>
                            <td>" . (isset($datos[5]) ? $datos[5] : '') . "</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No hay reservaciones aún.</p>";
            }
        } else {
            echo "<p>No hay reservaciones aún.</p>";
        }
        ?>
    </div>
    <div class="footer">
        <p>Universidad Florencio del Castillo</p>
    </div>
</body>
</html>
