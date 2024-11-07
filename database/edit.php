<?php
require_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Editar producto</h1>
  <?php
  if(!empty($_GET['id']) && !empty($_GET['name']) && !empty($_GET['price'])) {
  ?>
  <form action="update.php" method="post">
    <p>
      <input type="text" name="name" id="" placeholder="Nombre producto..." maxlength="30">
    </p>
    <p>
      <input type="number" name="price" id="" step="0.01">
    </p>
    <p>
      <button type="submit">Modificar</button>
    </p>
  </form>
  <?php
  }
  ?>
  <p>
    <a href="read.php">Volver a la tabla</a>
  </p>
</body>
</html>