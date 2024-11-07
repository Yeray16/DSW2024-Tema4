<?php

if(isset($_GET['username']) && isset($_GET['password'])) {
  $username = $_GET['username'];
  $password = $_GET['password'];

  echo "us: $username y pass: $password";

  require 'connection.php';

  $stmt = $link->stmt_init();
  $stmt->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
  $stmt->bind_param("ss", $username, $password);
  
  $stmt->execute();
  $results = $stmt->get_result();

  if($results->num_rows > 0) {
    echo "<h1>Bienvenido a la base de datos users</h1>";
  } else{
    echo "<h2>Error en el usuario/contraseña</h2>";
  }
  $stmt->close();
  $link->close();

  //Versión insegura
  //Se puede hacer inyección SQL poniendo en el input de username
  // $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  // $results = $link->query($sql);
  // if($results->num_rows > 0) {
  //   echo "<h1>Bienvenido a la base de datos users</h1>";
  // } else{
  //   echo "<h2>Error en el usuario/contraseña</h2>";
  // }
  // $link->close();
} else {
  echo "No existen los parámetros";
}
