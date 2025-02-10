<?php
function leerSaldos() {
    $saldos = [];
    // Suponiendo que saldoCuenta.txt está en la raíz del proyecto
    $rutaArchivo = 'saldoCuenta.txt';
    if (file_exists($rutaArchivo)) {
        $fichero = fopen($rutaArchivo, "r");
        while (($linea = fgets($fichero)) !== false) {
            $datos = explode(",", trim($linea));
            if (count($datos) >= 2) {
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
    $_SESSION['saldo'] = isset($saldos[$usuario]) ? $saldos[$usuario] : 0;
}

function actualizarSaldo() {
    $saldos = leerSaldos();
    $usuario = $_SESSION['usuario'];
    $saldos[$usuario] = $_SESSION['saldo'];
    
    $lineas = [];
    foreach ($saldos as $user => $saldo) {
        $lineas[] = "$user,$saldo";
    }
    // Guardar en la raiz del proyecto
    file_put_contents('saldoCuenta.txt', implode("\n", $lineas));
}
?>
