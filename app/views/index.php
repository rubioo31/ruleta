<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación de Usuario</title>
    <link rel="stylesheet" href="../../public/css/style.css">
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
            <td><input type="text" name="zona" id="zona" required></td>
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
            <td colspan="2" style="text-align:center;">
                <input type="submit" name="submit" value="Subir archivo">
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST["submit"])) {
    require_once APP_PATH . 'controllers/upload.php';
    echo datosFichero($_FILES['file']['name']);

    // Leer datos personales desde el archivo subido
    $datosPersonales = leerdatosPersonales();
    if (isset($datosPersonales['fecha_nacimiento'])) {
        $fechaNacimiento = DateTime::createFromFormat('d/m/Y', trim($datosPersonales['fecha_nacimiento']));
        if (!$fechaNacimiento) {
            echo "<br>ERROR: Formato de fecha incorrecto.";
        } else {
            $fechaActual = new DateTime();
            $edad = $fechaActual->diff($fechaNacimiento)->y;

            if ($edad < 18) {
                echo "<br>ERROR: Debes ser mayor de 18 años para realizar apuestas.";
            } else {
                echo "<br>Edad: $edad";
                echo "<br><a href='index.php?url=ruleta'>Ir a la página de apuestas</a>";
            }
        }
    } else {
        echo "<br>No se encontraron datos de fecha de nacimiento en el archivo.";
    }
}
?>
</body>
</html>
