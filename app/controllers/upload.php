<?php
function erroresFichero($fileError) {
    switch ($fileError) {
        case UPLOAD_ERR_OK:
            echo "No hay error, fichero subido con éxito<br>";
            break;
        case UPLOAD_ERR_INI_SIZE:
            echo "El fichero excede la directiva upload_max_filesize de php.ini<br>";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            echo "El fichero excede la directiva MAX_FILE_SIZE especificada en el formulario HTML<br>";
            break;
        case UPLOAD_ERR_PARTIAL:
            echo "El fichero fue solo parcialmente subido<br>";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "No se subió ningún fichero<br>";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo "Falta la carpeta temporal<br>";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo "No se pudo escribir el fichero en el disco<br>";
            break;
        case UPLOAD_ERR_EXTENSION:
            echo "Una extensión de PHP detuvo la subida de ficheros<br>";
            break;
    }
}

function sacarExtension($file) {
    return pathinfo($file, PATHINFO_EXTENSION);
}

function datosFichero($file) {
    $nombre    = $file;
    $extension = sacarExtension($file);
    $tamaño    = $_FILES['file']['size'];
    $tipo      = $_FILES['file']['type'];
    $tmp       = $_FILES['file']['tmp_name'];
    
    // Ruta relativa a la raíz del proyecto
    $destino = 'storage/documentosPersonales/' . $nombre;
    
    if (move_uploaded_file($tmp, $destino)) {
        /* echo "El archivo ha sido subido correctamente<br>"; */
    } else {
        echo "Hubo un problema al guardar el archivo en el directorio<br>";
    }
    
    return "DATOS FICHERO <br> Nombre: $nombre<br>Extensión: $extension<br>Tamaño: $tamaño<br>Tipo: $tipo<br>Temporal: $tmp<br>";
}

function leerdatosPersonales() {
    // Ruta relativa a la carpeta de almacenamiento
    $ruta = 'storage/documentosPersonales/' . $_FILES['file']['name'];
    $datosPersonales = [];
    
    if (file_exists($ruta)) {
        $fichero = fopen($ruta, "r");
        while (($linea = fgets($fichero)) !== false) {
            $partes = explode(":", trim($linea));
            if (count($partes) == 2) {
                list($clave, $valor) = $partes;
                $datosPersonales[$clave] = $valor;
            }
        }
        fclose($fichero);
    }
    
    return $datosPersonales;
}
?>
