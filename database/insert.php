<?php

if(!empty($_POST['name']) && !empty($_POST['price'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];
  echo $name." -- ".$price;

  require_once 'connection.php';

  $insertSQL = "INSERT INTO products (name, price) VALUES ('$name', $price)";
  $link->query($insertSQL);
  printf("Se ha insertado con éxito el producto $name con el precio: $price");
}
?>
<p>
  <a href="read.php">Volver a la tabla</a>
</p>