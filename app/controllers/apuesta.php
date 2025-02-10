<?php

function realizarApuesta() {
    $apuesta = $_POST['apuesta'];
    $tipo_apuesta = $_POST['tipo_apuesta'];
    $numero_apostado = isset($_POST['numero_apostado']) ? $_POST['numero_apostado'] : null;
    $mensaje = "";

    if ($apuesta > $_SESSION['saldo']) {
        $mensaje = 'ERROR: No tienes suficiente saldo para realizar esa apuesta.';
        echo "<script>
                alert(" . json_encode($mensaje) . ");
                window.location.href = 'index.php?url=ruleta';
              </script>";
        exit();
    }

    // Validación para apuesta de tipo 'numero'
    if ($tipo_apuesta === 'numero') {
        if ($numero_apostado === null || $numero_apostado < 0 || $numero_apostado > 36) {
            $mensaje = 'ERROR: El número apostado no es válido.';
            echo "<script>
                    alert(" . json_encode($mensaje) . ");
                    window.location.href = 'index.php?url=ruleta';
                  </script>";
            exit();
        }
    }

    $numero_ganador = rand(0, 36);
    $ganancia = 0;

    switch ($tipo_apuesta) {
        case 'numero':
            if ($numero_apostado == $numero_ganador) {
                $ganancia = $apuesta * 35;
                $mensaje = "¡Felicidades! Has ganado $ganancia apostando al número $numero_apostado.";
            } else {
                $mensaje = "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'red':
            $red = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];
            if (in_array($numero_ganador, $red)) {
                $ganancia = $apuesta * 2;
                $mensaje = "¡Felicidades! Has ganado $ganancia apostando al color rojo.";
            } else {
                $mensaje = "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'black':
            $black = [2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35];
            if (in_array($numero_ganador, $black)) {
                $ganancia = $apuesta * 2;
                $mensaje = "¡Felicidades! Has ganado $ganancia apostando al color negro.";
            } else {
                $mensaje = "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'par':
            if ($numero_ganador % 2 == 0) {
                $ganancia = $apuesta * 2;
                $mensaje = "¡Felicidades! Has ganado $ganancia apostando a par.";
            } else {
                $mensaje = "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        case 'impar':
            if ($numero_ganador % 2 != 0) {
                $ganancia = $apuesta * 2;
                $mensaje = "¡Felicidades! Has ganado $ganancia apostando a impar.";
            } else {
                $mensaje = "Lo siento, has perdido. El número ganador es $numero_ganador.";
            }
            break;
        default:
            $mensaje = 'ERROR: La apuesta no se ha realizado correctamente.';
            echo "<script>
                    alert(" . json_encode($mensaje) . ");
                    window.location.href = 'index.php?url=ruleta';
                  </script>";
            exit();
    }

    // Actualizar el saldo del usuario
    $_SESSION['saldo'] += $ganancia - $apuesta;
    actualizarSaldo();
    $mensaje .= " Tu saldo actual es {$_SESSION['saldo']}.";
    
    echo "<script>
            alert(" . json_encode($mensaje) . ");
            window.location.href = 'index.php?url=ruleta';
          </script>";
    exit();
}
?>
