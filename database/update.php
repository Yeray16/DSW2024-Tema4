<?php

if(!empty($_POST['name']) && !empty($_POST['price'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $id = $_GET['id'];

  require_once 'connection.php';

  $updatetSQL = "UPDATE products SET name ='$name', price = $price WHERE id = $id";
  $link->query($updateSQL);
  printf("Se ha actualizado con éxito el producto $name con el precio: $price");
}
?>
<p>
  <a href="read.php">Volver a la tabla</a>
</p>