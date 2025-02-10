<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ruleta</title>
  <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
  <h1>Bienvenido a la ruleta</h1>
  <div class="saldo-container">
    <?php echo "<p>Saldo actual: €" . $_SESSION['saldo'] . "</p>"; ?>
    <form action="logout.php" method="post">
      <button type="submit">Cerrar sesión</button>
    </form>
  </div>

  <table id="tablero" class="tablero">
    <tr>
      <td rowspan="4" class="green">0</td>
    </tr>
    <?php
      $numbers = [
          [3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36],
          [2, 5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35],
          [1, 4, 7, 10, 13, 16, 19, 22, 25, 28, 31, 34]
      ];
      $red = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];
      $black = [2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35];

      foreach ($numbers as $row) {
          echo "<tr>";
          foreach ($row as $number) {
              if (in_array($number, $red)) {
                  echo "<td class='red'>$number</td>";
              } elseif (in_array($number, $black)) {
                  echo "<td class='black'>$number</td>";
              }
          }
          echo "</tr>";
      }
    ?>
  </table>

  <h2>Realice su apuesta</h2>
  <form action="index.php?url=ruleta" method="post">
    <table id="apuestas" class="apuestas">
      <tr>
        <td><label for="apuesta">Apuesta (en €):</label></td>
        <td><input type="number" id="apuesta" name="apuesta" required></td>
      </tr>
      <tr>
        <td><label for="tipo_apuesta">Tipo de apuesta:</label></td>
        <td>
          <select name="tipo_apuesta" id="tipo_apuesta">
            <option value="numero">Número</option>
            <option value="red">Rojo</option>
            <option value="black">Negro</option>
            <option value="par">Par</option>
            <option value="impar">Impar</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="numero_apostado">Introduce el número:</label></td>
        <td><input type="number" id="numero_apostado" name="numero_apostado"></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;">
          <input type="submit" name="submit_apuesta" value="Realizar apuesta">
        </td>
      </tr>
    </table>
  </form>

  <?php
    if (isset($_POST['submit_apuesta'])) {
      require 'app/controllers/apuesta.php';
      realizarApuesta();
      header("Location: index.php?url=ruleta");
      exit();
    }
  ?>
</body>
</html>
