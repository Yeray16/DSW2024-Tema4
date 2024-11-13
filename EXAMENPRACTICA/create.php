<?php 
    include "top.php"; 
    require 'connectionPDO.php';
    $message = '';
    if (isset($_POST['create'])) {

        try{
            $category_name =isset($_POST['name']) ? ($_POST['name']) : '';

            //Insertamos la categoría
            $stmtInsertCategory = $link->prepare('INSERT INTO category (category_id, name, last_update) VALUES (NULL, :name, CURRENT_TIMESTAMP)');
            $stmtInsertCategory->bindParam(':name', $category_name);
            $stmtInsertCategory->execute();

            //Si es >0 significa que se ha insertado una categoría
            if($stmtInsertCategory->rowCount() > 0) {
                $message = '<div class="alert alert-success">¡Categoría insertada correctamente!</div>';
            }

        }   catch (Exception $e) {
            die('Error '.$e->getMessage());
        }
?>
<section id="create">
    <h2>Nueva categoría</h2>
    <nav>
        <p><a href="film.php">Volver</a></p>
    </nav>
    <?php
        if(!empty($message)){
            echo $message;
        }
    } else {
    ?>
    <form action="create.php" method="post" autocomplete="off">
        <fieldset>
            <legend>Datos de la categoría</legend>
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" required>
            <p></p>
            <input type="reset" value="Limpiar">            
            <input type="submit" name ="create" value="Crear">
        </fieldset>
    </form>
    <?php
    }
    ?>
</section>
<?php include "bottom.php"; ?>