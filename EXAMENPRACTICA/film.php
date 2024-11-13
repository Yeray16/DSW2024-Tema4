<?php
include "top.php";
require 'connectionPDO.php';
if (isset($_GET['delete'])) { 
    try { 
        $category_id = isset($_GET['category']) ? ($_GET['category']) : ''; // Verificar si la categoría tiene películas asociadas 
        
        $stmtCheckMovies = $link->prepare('SELECT COUNT(*) FROM film_category WHERE category_id = :category_id'); 
        $stmtCheckMovies->bindParam(':category_id', $category_id); 
        $stmtCheckMovies->execute(); 
        $movieCount = $stmtCheckMovies->fetchColumn(); 

        if ($movieCount > 0) { 
            $message = '<div class="alert alert-error">No se puede borrar la categoría porque tiene películas asociadas. Elimina las películas primero.</div>';
        } else { 
            $stmtDeleteCategory = $link->prepare('DELETE FROM category WHERE category_id = :category_id'); 
            $stmtDeleteCategory->bindParam(':category_id', $category_id); 
            $stmtDeleteCategory->execute(); 
            if ($stmtDeleteCategory->rowCount() > 0) { 
                $message = '<div class="alert alert-success">¡Categoría eliminada correctamente!</div>'; 
            }
        } 
    } catch (Exception $e) { 
        die('Error ' . $e->getMessage()); 
    } 
}
?>
<!--
    <div class="alert alert-success">¡Ejemplo mensaje de éxito!</div>
    <div class="alert alert-error">¡Ejemplo mensaje de error!</div>
    -->

<section id="films">
    <h2>Peliculas</h2>
    <?php
    $category_film = isset($_GET['category']) ? $_GET['category'] : '';

    try {
        $stmtCategory = $link->prepare('SELECT category_id, name FROM category');
        $stmtCategory->execute();
        $categories = $stmtCategory->fetchAll(PDO::FETCH_OBJ);

    ?>
        <form action="film.php" method="get">
            <fieldset>
                <legend>Categorías</legend>
                <select name="category" id="">
                    <option selected disabled>Elige una categoría</option>
                    <?php
                    foreach ($categories as $category) {
                        printf('<option value="%d">%s</option>', $category->category_id, $category->name);
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
        <?php
        if (!empty($category_film) && !isset($_GET['delete'])) {
            $stmtTable = $link->prepare('SELECT film.film_id, film.title, film.release_year, film.length FROM film, film_category WHERE film.film_id = film_category.film_id AND film_category.category_id = :category_film');
            $stmtTable->bindParam(':category_film', $category_film, PDO::PARAM_INT);
            $stmtTable->execute();
            $films = $stmtTable->fetchAll(PDO::FETCH_OBJ);

            if ($films) {
        ?>
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
                        foreach ($films as $film) {
                            printf(
                                '<tr><td>%s</td><td>%d</td><td>%d</td><td><a href="category_film.php?film_id=%d"><input type="submit" value="Cambiar categoría"></a></td>',
                                $film->title,
                                $film->release_year,
                                $film->length,
                                $film->film_id
                            );
                        }
                        ?>
                    </tbody>
                </table>
    <?php
            } else {
                echo '<div class="alert alert-error">Esta categoría no tiene películas.</div>';
            }
        }
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }

    if(!empty($message)){
        echo $message;
    }
    ?>
</section>
<?php include "bottom.php"; ?>