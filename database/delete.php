<?php
require_once 'connection.php';

if(!empty($_GET['id'])){
  $id=$_GET['id'];
  $deleteSQL = "DELETE FROM products WHERE id=$id";
  $link->query($deleteSQL);
  echo "Eliminado el producto con id: $id";
}
?>

<p>
  <a href="read.php">Volver a la tabla</a>
</p>