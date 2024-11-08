<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito de Compra</title>
</head>
<body>
  <?php include 'menu.php'; ?>
  <?php
    $username = isset($_GET['username']) ? $_GET['username'] : '';
  ?>
  <h1>Carritos de compra de <?=$username?></h1>
  <h2>Pendientes de procesado</h2>
  <?php
    require 'connectionPDO.php';
    $stmtCart = $link->prepare('SELECT products.id, name, price, username, amount FROM products INNER JOIN cart ON products.id = cart.id WHERE username=:username');
    $stmtCart->bindParam(':username', $username);
  ?>
  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $stmtCart->execute();
        $total = 0;
        while($row = $stmtCart->fetchObject()) {
          $subtotal = $row->price * $row->amount;
          $total += $subtotal;
          printf("<tr><td>%s</td><td>%.2f€</td><td>%d</td><td>%.2f€</td></tr>",
                  $row->name, $row->price, $row->amount, $subtotal);
        }
        $stmtCart = null;
        $link = null;
      ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3">Total</th>
        <td>
          <?= sprintf("%.2f€", $total);?>
        </td>
      </tr>
    </tfoot>
  </table>
</body>
</html>