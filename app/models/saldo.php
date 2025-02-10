<?php
function leerSaldos() {
    $saldos = [];
    $rutaArchivo = BASE_PATH . 'saldoCuenta.txt';
    if (file_exists($rutaArchivo)) {
        $fichero = fopen($rutaArchivo, "r");
        while (($linea = fgets($fichero)) !== false) {
            $datos = explode(",", trim($linea));
            if (count($datos) >= 2) {
                // Uso el nombre de usuario como clave y saldo como valor
                $saldos[$datos[0]] = $datos[1];
            }
        }
        fclose($fichero);
    }
    return $saldos;
}

function asignarSaldo() {
    $saldos = leerSaldos();
    $usuario = $_SESSION['usuario'];
    if (isset($saldos[$usuario])) {
        $_SESSION['saldo'] = $saldos[$usuario];
    } else {
        $_SESSION['saldo'] = 0;
    }
}

function actualizarSaldo() {
    $saldos = leerSaldos();
    $usuario = $_SESSION['usuario'];
    $saldos[$usuario] = $_SESSION['saldo'];

    $lineas = [];
    foreach ($saldos as $user => $saldo) {
        $lineas[] = "$user,$saldo";
    }
    file_put_contents(BASE_PATH . 'saldoCuenta.txt', implode("\n", $lineas));
}
?>
