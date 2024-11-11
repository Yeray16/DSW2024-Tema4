<?php 
    include "top.php";
    require 'connectionPDO.php';
?>
    <!--
    <div class="alert alert-success">¡Ejemplo mensaje de éxito!</div>
    <div class="alert alert-error">¡Ejemplo mensaje de error!</div>
    -->

    <section id="films">
        <h2>Peliculas</h2>
        <?php
            $category_film = $_GET['film'];

            try{
                $stmtCategory = $link->prepare('SELECT category_id, name FROM category');
                $stmtCategory->execute();
                $categories = $stmtCategory->fetchAll(PDO::FETCH_OBJ);

                $stmtTable = $link->prepare('SELECT title FROM film INNER JOIN film_category ON film.film_id = film_category.film_id INNER JOIN category ON film_category.category_id = category.category_id WHERE category_id=:category_id');
                $stmtTable->bindParam(':category_film', $category_film);
        ?>
        <form action="film.php" method="get">
          <fieldset>
            <legend>Categorías</legend>
            <select name="category" id="">
              <option selected disabled>Elige una categoría</option>  
              <?php
                foreach($categories as $category) {
                    printf('<option value="film">%s</option>', $category->name);
                }
              ?>            
            </select>
            <input type="submit" name="search" value="buscar">
            <input type="submit" name="delete" value="eliminar">
          </fieldset>
        </form>
        <?php
            $stmtCategory = null;    
        ?>
        <nav>
            <fieldset>
                <legend>Acciones</legend>                    
                <a href="create.php">
                    <button>Crear Categoria</button>
                </a>                    
            </fieldset>
        </nav>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Año</th>
                    <th>Duración</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stmtTable->execute();
                    $films = $stmtTable->fetchAll(PDO::FETCH_OBJ);
                    foreach($films as $film){
                        printf('<tr><td>%s</td><td>%d</td><td>%d</td>',
                                $film->title, $film->release_year, $film->length);
                    }
                    
                } catch (Exception $e){
                    die('Se jodio: '. $e->getMessage());
                } 
                ?>
                <!-- <tr>
                    <td>El tercer hombre</td>
                    <td class="center">1949</td>
                    <td class="center">108</td>
                    <td class="actions">                            
                        <a class="button" href="category_film.php?...">
                            <button>Cambiar categorías</button>
                        </a>               
                    </td>
                </tr> -->
            </tbody>
        </table>
    </section>
<?php include "bottom.php"; ?>