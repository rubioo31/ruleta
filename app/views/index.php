<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación de Usuario</title>
    <link rel="stylesheet" href="public/css/validacion.css"> 
</head>
<body>
    <h1>Validación de Usuario</h1>
    <form action="index.php?url=index" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="file">Seleccionar archivo:</label></td>
                <td><input type="file" name="file" id="file" required></td>
            </tr>
            <tr>
                <td><label for="zona">Zona horaria:</label></td>
                <td><input type="text" name="zona" id="zona" placeholder="Ej: UTC-5" required></td>
            </tr>
            <tr>
                <td><label for="idioma">Idioma:</label></td>
                <td>
                    <select name="idioma" id="idioma">
                        <option value="es">Español</option>
                        <option value="en">Inglés</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input type="submit" name="submit" value="Subir archivo">
                </td>
            </tr>
        </table>
    </form>

    <?php
    if (isset($_POST["submit"])) {
        require 'app/controllers/upload.php';

        // Mostrar los datos del fichero dentro de un contenedor estilizado
        echo '<div class="data-container">' . datosFichero($_FILES['file']['name']) . '</div>';

        // Leer datos personales desde el archivo subido
        $datosPersonales = leerdatosPersonales();
        if (isset($datosPersonales['fecha_nacimiento'])) {
            $fechaNacimiento = DateTime::createFromFormat('d/m/Y', trim($datosPersonales['fecha_nacimiento']));
            if (!$fechaNacimiento) {
                echo '<div class="validation-message error"><br>ERROR: Formato de fecha incorrecto.</div>';
            } else {
                $fechaActual = new DateTime();
                $edad = $fechaActual->diff($fechaNacimiento)->y;

                if ($edad < 18) {
                    echo '<div class="validation-message error"><br>ERROR: Debes ser mayor de 18 años para realizar apuestas.</div>';
                } else {
                    echo '<div class="validation-message success"><br>Edad: ' . $edad . '</div>';
                    echo '<div class="link-container"><a href="index.php?url=ruleta">Ir a la página de apuestas</a></div>';
                }
            }
        } else {
            echo '<div class="validation-message error"><br>No se encontraron datos de fecha de nacimiento en el archivo.</div>';
        }
    }
    ?>
</body>
</html>
