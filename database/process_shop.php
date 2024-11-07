<?php require 'connectionPDO.php'; 

  if(isset($_POST['username'])){
    $stmt = $link->prepare('INSERT INTO cart (id, username, amount) VALUES (:id, :username, :amount)');
    $stmt->bindParam(':id', $clave);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':amount', $valor);
    $username = $_POST['username'];

    foreach($_POST as $clave => $valor){
      if(is_numeric($valor) && $valor > 0){
      printf("<p>clave: %s => valor: %s</p>", $clave, $valor);
      $stmt->execute();
      }
    }
  }
?>
