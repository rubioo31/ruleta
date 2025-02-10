<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autenticación
require 'app/controllers/auth.php';
autenticarUsuario();

// Saldo del usuario
require 'app/models/saldo.php';
asignarSaldo();

// Enrutamiento
$url = isset($_GET['url']) ? $_GET['url'] : 'index';

switch ($url) {
    case 'index':
        include 'app/views/index.php';
        break;
    case 'ruleta':
        include 'app/views/ruleta.php';
        break;
    default:
        echo "Página no encontrada.";
        break;
}
?>