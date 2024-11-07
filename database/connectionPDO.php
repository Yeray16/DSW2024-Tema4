<?php
$user = 'shopuser';
$password = '123456';
$dsn = "mysql:host=localhost;dbname=shop";

try {
  $link = new PDO($dsn, $user, $password);
  $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
  die("Error en la conexión: ".$ex->getMessage());
}
