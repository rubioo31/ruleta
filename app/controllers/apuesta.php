<?php
require_once APP_PATH . 'models/saldo.php';

function realizarApuesta() {
    $apuesta = $_POST['apuesta'];
    $tipo_apuesta = $_POST['tipo_apuesta'];
    $numero_apostado = isset($_POST['numero_apostado']) ? $_POST['numero_apostado'] : null;

    if ($apuesta > $_SESSION['saldo']) {
        echo 'ERROR: No tienes suficiente saldo para realizar esa apuesta.';
        return;
    }

    // Validación para apuesta de tipo 'numero'
    if ($tipo_apuesta === 'numero') {
        if ($numero_apostado === null || $numero_apostado < 0 || $numero_apostado > 36) {
            echo 'ERROR: El número apostado no es válido.';
            return;
        }
    }

    $numero_ganador = rand(0, 36);
    $ganancia = 0;

    switch ($tipo_apuesta) {
        case 'numero':
            if ($numero_apostado == $numero_ganador) {
                $ganancia = $apuesta * 35;
                echo "¡Felicidades! Has ganado $ganancia apostando al número $numero_apostado.";
            } else {
                echo "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'red':
            $red = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];
            if (in_array($numero_ganador, $red)) {
                $ganancia = $apuesta * 2;
                echo "¡Felicidades! Has ganado $ganancia apostando al color rojo.";
            } else {
                echo "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'black':
            $black = [2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35];
            if (in_array($numero_ganador, $black)) {
                $ganancia = $apuesta * 2;
                echo "¡Felicidades! Has ganado $ganancia apostando al color negro.";
            } else {
                echo "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'par':
            if ($numero_ganador % 2 == 0) {
                $ganancia = $apuesta * 2;
                echo "¡Felicidades! Has ganado $ganancia apostando a par.";
            } else {
                echo "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'impar':
            if ($numero_ganador % 2 != 0) {
                $ganancia = $apuesta * 2;
                echo "¡Felicidades! Has ganado $ganancia apostando a impar.";
            } else {
                echo "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        default:
            echo 'ERROR: La apuesta no se ha realizado correctamente.';
            return;
    }

    // Actualizar saldo: se descuenta la apuesta y se suma la ganancia
    $_SESSION['saldo'] += $ganancia - $apuesta;
    actualizarSaldo();
    echo " Tu saldo actual es {$_SESSION['saldo']}.";
}
