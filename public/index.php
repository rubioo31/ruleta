<?php
// Rutas
define('BASE_PATH', dirname(__DIR__) . '/');
define('APP_PATH', BASE_PATH . 'app/');
define('STORAGE_PATH', BASE_PATH . 'storage/');

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autenticación
require_once APP_PATH . 'controllers/auth.php';
autenticarUsuario();

// Saldo del usuario
require_once APP_PATH . 'models/saldo.php';
asignarSaldo();

// Rutas
$url = isset($_GET['url']) ? $_GET['url'] : 'index';

switch ($url) {
    case 'index':
        include APP_PATH . 'views/index.php';
        break;
    case 'ruleta':
        include APP_PATH . 'views/ruleta.php';
        break;
    default:
        echo "Página no encontrada.";
        break;
}
?>