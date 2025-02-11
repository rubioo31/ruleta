<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function autenticarUsuario()
{
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="Contenido restringido"');
        header('HTTP/1.0 401 Unauthorized');
        exit('Usuario no autenticado');
    }
    
    $htpasswd_path = '.htpasswd';
    if (!file_exists($htpasswd_path)) {
        exit("El archivo de usuarios (.htpasswd) no existe en la ruta: $htpasswd_path");
    }
    
    $usuarios = file($htpasswd_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $autenticado = false;
    
    foreach ($usuarios as $linea) {
        if (strpos($linea, ':') === false) {
            continue; // Saltar lineas mal formateadas
        }
        list($user, $hash) = explode(":", trim($linea), 2);
        if ($_SERVER['PHP_AUTH_USER'] == $user && md5($_SERVER['PHP_AUTH_PW']) == $hash) {
            $autenticado = true;
            $_SESSION['usuario'] = $user;
            break;
        }
    }
    
    if (!$autenticado) {
        exit('Usuario no autorizado');
    }
}
?>
