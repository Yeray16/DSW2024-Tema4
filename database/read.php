<?php
  require_once 'connection.php'; //conexion de mysqli
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    th,td {
      border: 1px solid blue;
      padding: 4px 10px;
    }
  </style>
</head>
<body>
  <?php include 'menu.php'; ?>
  <h1>Tabla Productos</h1>
  <p>
    <a href="create.html">Crear nuevo Producto</a>
  </p>
  <table>
    <thead>
      <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      //Hacemos la consulta
      $result = $link->query('SELECT * FROM products ORDER BY price DESC');
      //Fetch nos permite organizar los registros que hemos 
      //seleccionado en objectos por usamos _object
      while ($product = $result->fetch_object()) {
        echo "<tr>";
        printf('<td>%d</td>', $product->id);      
        printf('<td>%s</td>', $product->name);      
        printf('<td>%.2f</td>', $product->price);
        printf('<td><a href="delete.php?id=%d">eliminar</a></td>', $product->id);    
        printf('<td><a href="edit.php?id=%d">editar</a></td>', $product->id, $product->name, $product->price);    
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>